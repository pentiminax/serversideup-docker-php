<?php

namespace App\Controller;

use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(TaskRepository $taskRepository): Response
    {
        return $this->render('dashboard/index.html.twig', [
            'statusCounts' => $taskRepository->countByStatus(),
            'priorityCounts' => $taskRepository->countByPriority(),
            'recentTasks' => $taskRepository->findRecent(5),
        ]);
    }
}
