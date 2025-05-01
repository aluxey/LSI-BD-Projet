<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectsController extends AbstractController
{
    #[Route('/projects', name: 'app_projects')]
    public function index(): Response
    {
        return $this->render('projects/index.html.twig');
    }

    #[Route('/project/{id}', name: 'app_project_show')]
public function show(): Response
{
    $project = [
        'name' => 'Projet Alpha',
        'description' => 'Projet de démonstration sans base de données',
        'status' => 'En cours',
        'startDate' => new \DateTime('2025-04-01'),
        'endDate' => new \DateTime('2025-06-30'),
        'budget' => 50000,
        'progress' => 65,
        'phases' => [
            ['name' => 'Phase 1', 'planned' => 80, 'actual' => 75],
            ['name' => 'Phase 2', 'planned' => 50, 'actual' => 40],
            ['name' => 'Phase 3', 'planned' => 30, 'actual' => 20],
        ],
        'milestones' => [
            ['name' => 'Kickoff', 'date' => new \DateTime('2025-04-02'), 'completed' => true],
            ['name' => 'Prototype', 'date' => new \DateTime('2025-05-10'), 'completed' => false],
        ],
        'tasks' => [
            [
                'name' => 'Conception UI',
                'dueDate' => new \DateTime('2025-04-15'),
                'assignee' => 'Alice',
                'status' => 'completed',
                'priority' => 'high',
            ],
            [
                'name' => 'Intégration backend',
                'dueDate' => new \DateTime('2025-05-01'),
                'assignee' => 'Bob',
                'status' => 'in_progress',
                'priority' => 'medium',
            ],
        ],
        'activities' => [
            [
                'userName' => 'Alice',
                'userInitials' => 'A',
                'userColor' => '#8655FA',
                'action' => 'a complété la tâche "Conception UI".',
                'comment' => 'Super travail !',
                'time' => 'il y a 2 heures',
            ],
            [
                'userName' => 'Bob',
                'userInitials' => 'B',
                'userColor' => '#E953B8',
                'action' => 'a commencé la tâche "Intégration backend".',
                'comment' => null,
                'time' => 'il y a 1 jour',
            ],
        ],
    ];

    return $this->render('projects/show.html.twig', [
        'project' => $project,
    ]);
}


    #[Route('/projects/{id}/delete', name: 'app_project_delete', methods: ['POST'])]
    public function delete(int $id): Response
    {
        // Logique pour supprimer un projet par ID
        return $this->redirectToRoute('app_projects');
    }

    #[Route('/projects/create', name: 'app_project_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        // Logique pour créer un projet depuis un formulaire soumis
        return $this->redirectToRoute('app_projects');
    }

    #[Route('/projects/{id}/edit', name: 'app_project_edit', methods: ['GET', 'POST'])]
    public function edit(int $id, Request $request): Response
    {
        // Logique pour afficher/modifier un projet
        return $this->render('projects/edit.html.twig', ['id' => $id]);
    }
}
