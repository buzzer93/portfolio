<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', name: 'admin_')]
class DashboardController extends AbstractController
{
    #[Route('', name: 'dashboard')]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('admin/dashboard/index.html.twig', [
            'activeProjects' => $projectRepository->findActiveOrdered(),
            'inactiveProjects' => $projectRepository->findInactiveOrdered(),
        ]);
    }
}
