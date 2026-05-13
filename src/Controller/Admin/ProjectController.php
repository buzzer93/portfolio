<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Form\Admin\ProjectType;
use App\Repository\ProjectRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/projects', name: 'admin_project_')]
class ProjectController extends AbstractController
{
    public function __construct(
        private readonly FileUploader $fileUploader,
        #[Autowire('%kernel.project_dir%/public/images')]
        private readonly string $imagesDir,
    ) {
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form->get('imageFiles')->getData() as $file) {
                $filename = $this->fileUploader->upload($file, $this->imagesDir);
                $project->setImages([...$project->getImages(), $filename]);
            }

            $em->persist($project);
            $em->flush();

            $this->addFlash('success', 'Projet créé avec succès.');

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/project/form.html.twig', [
            'form'    => $form,
            'project' => $project,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(Project $project, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageOrderRaw = $request->request->get('image_order', '');
            $orderedImageNames = [];
            if (is_string($imageOrderRaw) && $imageOrderRaw !== '') {
                $decoded = json_decode($imageOrderRaw, true);
                if (is_array($decoded)) {
                    $orderedImageNames = array_values(array_unique(array_map(
                        static fn(string $name): string => basename(str_replace('\\', '/', $name)),
                        array_filter($decoded, static fn(mixed $v): bool => is_string($v) && $v !== ''),
                    )));
                }
            }

            if ($orderedImageNames !== []) {
                $imagesByName = [];
                foreach ($project->getImages() as $image) {
                    $imagesByName[basename(str_replace('\\', '/', $image))] = $image;
                }

                $reorderedImages = [];
                foreach ($orderedImageNames as $name) {
                    if (isset($imagesByName[$name])) {
                        $reorderedImages[] = $imagesByName[$name];
                        unset($imagesByName[$name]);
                    }
                }

                $project->setImages([...$reorderedImages, ...array_values($imagesByName)]);
            }

            $deleteImages = $request->request->all()['delete_images'] ?? [];
            $deleteImageNames = array_values(array_unique(array_map(
                static fn(string $name): string => basename(str_replace('\\', '/', $name)),
                array_filter($deleteImages, static fn(mixed $v): bool => is_string($v) && $v !== ''),
            )));

            if ($deleteImageNames !== []) {
                $project->setImages(array_values(array_filter(
                    $project->getImages(),
                    static fn(string $img): bool => !in_array(
                        basename(str_replace('\\', '/', $img)),
                        $deleteImageNames,
                        true,
                    ),
                )));
            }

            foreach ($form->get('imageFiles')->getData() as $file) {
                $filename = $this->fileUploader->upload($file, $this->imagesDir);
                $project->setImages([...$project->getImages(), $filename]);
            }

            $em->flush();

            foreach ($deleteImageNames as $filename) {
                $this->fileUploader->remove($this->imagesDir, $filename);
            }

            $this->addFlash('success', 'Projet mis à jour.');

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('admin/project/form.html.twig', [
            'form'    => $form,
            'project' => $project,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(Project $project, Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->isCsrfTokenValid('delete-project-' . $project->getId(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');

            return $this->redirectToRoute('admin_dashboard');
        }

        foreach ($project->getImages() as $filename) {
            $this->fileUploader->remove($this->imagesDir, $filename);
        }

        $em->remove($project);
        $em->flush();

        $this->addFlash('success', 'Projet supprimé.');

        return $this->redirectToRoute('admin_dashboard');
    }

    #[Route('/{id}/toggle-status', name: 'toggle_status', methods: ['POST'])]
    public function toggleStatus(Project $project, Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->isCsrfTokenValid('toggle-project-status-' . $project->getId(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Token CSRF invalide.');

            return $this->redirectToRoute('admin_dashboard');
        }

        $project->setIsActive(!$project->isActive());
        $em->flush();

        $this->addFlash('success', $project->isActive() ? 'Projet activé.' : 'Projet désactivé.');

        return $this->redirectToRoute('admin_dashboard');
    }

    #[Route('/reorder', name: 'reorder', methods: ['POST'])]
    public function reorder(Request $request, ProjectRepository $repository, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!is_array($data)) {
            return new JsonResponse(['error' => 'Invalid payload'], 400);
        }

        foreach ($data as $item) {
            $project = $repository->find($item['id']);
            if ($project) {
                $project->setPosition((int) $item['position']);
            }
        }

        $em->flush();

        return new JsonResponse(['ok' => true]);
    }
}
