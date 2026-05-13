<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Profile;
use App\Form\Admin\ProfileType;
use App\Repository\ProfileRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/profile', name: 'admin_profile_')]
class ProfileController extends AbstractController
{
    public function __construct(
        private readonly FileUploader $fileUploader,
        #[Autowire('%kernel.project_dir%/public/images/profile')]
        private readonly string $photoDir,
        #[Autowire('%kernel.project_dir%/public/files')]
        private readonly string $filesDir,
    ) {
    }

    #[Route('', name: 'edit')]
    public function edit(Request $request, ProfileRepository $repository, EntityManagerInterface $em): Response
    {
        $profile = $repository->findProfile() ?? new Profile();
        $isNew = $profile->getId() === null;

        $form = $this->createForm(ProfileType::class, $profile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photoFile')->getData();
            if ($photoFile) {
                if ($profile->getPhotoPath()) {
                    $this->fileUploader->remove($this->photoDir, $profile->getPhotoPath());
                }
                $profile->setPhotoPath($this->fileUploader->upload($photoFile, $this->photoDir));
            }

            $cvFile = $form->get('cvFile')->getData();
            if ($cvFile) {
                if ($profile->getCvPath()) {
                    $this->fileUploader->remove($this->filesDir, $profile->getCvPath());
                }
                $profile->setCvPath($this->fileUploader->upload($cvFile, $this->filesDir));
            }

            if ($isNew) {
                $em->persist($profile);
            }

            $em->flush();

            $this->addFlash('success', 'Profil mis à jour.');

            return $this->redirectToRoute('admin_profile_edit');
        }

        return $this->render('admin/profile/edit.html.twig', [
            'form'    => $form,
            'profile' => $profile,
        ]);
    }
}
