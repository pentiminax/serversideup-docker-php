<?php

namespace App\Controller;

use App\Entity\Task;
use App\Enum\TaskStatus;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tasks')]
class TaskController extends AbstractController
{
    #[Route('', name: 'app_task_index')]
    public function index(Request $request, TaskRepository $taskRepository): Response
    {
        $status = $request->query->getString('status');
        $priority = $request->query->getString('priority');

        $tasks = $taskRepository->findByStatusFilter(
            $status ?: null,
            $priority ?: null
        );

        return $this->render('task/index.html.twig', [
            'tasks' => $tasks,
            'currentStatus' => $status,
            'currentPriority' => $priority,
        ]);
    }

    #[Route('/new', name: 'app_task_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'Tâche créée avec succès !');
            return $this->redirectToRoute('app_task_index');
        }

        return $this->render('task/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_task_show', requirements: ['id' => '\d+'])]
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_task_edit', requirements: ['id' => '\d+'])]
    public function edit(Request $request, Task $task, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Tâche mise à jour !');
            return $this->redirectToRoute('app_task_show', ['id' => $task->getId()]);
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/toggle', name: 'app_task_toggle', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function toggle(Request $request, Task $task, EntityManagerInterface $em): Response
    {
        if (!$this->isCsrfTokenValid('toggle-task-'.$task->getId(), $request->getPayload()->getString('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $task->setStatus(
            $task->getStatus() === TaskStatus::Done ? TaskStatus::Todo : TaskStatus::Done
        );
        $em->flush();

        return $this->render('task/_card.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_task_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Task $task, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete-task-'.$task->getId(), $request->getPayload()->getString('_token'))) {
            $em->remove($task);
            $em->flush();
            $this->addFlash('success', 'Tâche supprimée.');
        }

        return $this->redirectToRoute('app_task_index');
    }
}
