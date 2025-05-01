<?php

namespace App\Controller;

use App\Repository\MembreRepository;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DashboardsController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(
        MembreRepository $membreRepository,
        ProjetRepository $projetRepository
    ): Response {
        $data = [
            'projects' => $this->getProjects(),
            'upcomingEvents' => $this->getUpcomingEvents(),
            'pendingTasks' => $this->getPendingTasks(),
            'unreadMessages' => $this->getUnreadMessages(),
            'activeMembers' => $this->getActiveMembers(),
        ];

        $membres = $membreRepository->findAll();
        $projets = $projetRepository->findAll();

        return $this->render('dashboard/index.html.twig', [
            'data' => $data,
            'membres' => $membres,
            'projets' => $projets,
        ]);
    }

    private function getProjects(): array
{
    return [
        [
            'id' => 1,
            'name' => 'Refonte du site web',
            'deadline' => '2023-06-22',
            'progress' => 75,
            'status' => 'En cours',
            'members' => [
                ['initials' => 'JD', 'color' => 'blue-500'],
                ['initials' => 'AL', 'color' => 'green-500'],
                ['initials' => 'MK', 'color' => 'purple-500'],
                ['initials' => 'RB', 'color' => 'yellow-500'],
                ['initials' => 'SC', 'color' => 'red-500'],
            ],
        ],
        [
            'id' => 2,
            'name' => 'Application mobile',
            'deadline' => '2023-07-15',
            'progress' => 30,
            'status' => 'En cours',
            'members' => [
                ['initials' => 'TS', 'color' => 'red-500'],
                ['initials' => 'RK', 'color' => 'yellow-500'],
                ['initials' => 'JD', 'color' => 'blue-500'],
                ['initials' => 'MK', 'color' => 'purple-500'],
                ['initials' => 'PL', 'color' => 'green-500'],
            ],
        ],
        [
            'id' => 3,
            'name' => 'Campagne marketing Q3',
            'deadline' => '2023-08-01',
            'progress' => 10,
            'status' => 'Nouveau',
            'members' => [
                ['initials' => 'LM', 'color' => 'pink-500'],
                ['initials' => 'PD', 'color' => 'indigo-500'],
            ],
        ],
    ];
}


    private function getUpcomingEvents(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Réunion d\'équipe',
                'date' => 'Aujourd\'hui',
                'time' => '14:00 - 15:30',
                'color' => 'var(--primary)',
            ],
            [
                'id' => 2,
                'title' => 'Deadline projet Nexus',
                'date' => '22 Juin',
                'time' => 'Toute la journée',
                'color' => '#E953B8',
            ],
            [
                'id' => 3,
                'title' => 'Formation UX Design',
                'date' => '24 Juin',
                'time' => '09:00 - 12:00',
                'color' => '#4CAF50',
            ],
        ];
    }

    private function getPendingTasks(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Finaliser les maquettes',
                'project' => 'Refonte du site web',
                'deadline' => '2023-06-18',
                'priority' => 'Haute',
            ],
            [
                'id' => 2,
                'title' => 'Tester l\'API de paiement',
                'project' => 'Application mobile',
                'deadline' => '2023-06-20',
                'priority' => 'Moyenne',
            ],
            [
                'id' => 3,
                'title' => 'Rédiger le contenu marketing',
                'project' => 'Campagne marketing Q3',
                'deadline' => '2023-06-25',
                'priority' => 'Basse',
            ],
        ];
    }

    private function getUnreadMessages(): array
    {
        return [
            [
                'id' => 1,
                'sender' => 'Marie Keller',
                'subject' => 'Question sur le design system',
                'date' => 'Il y a 2h',
            ],
            [
                'id' => 2,
                'sender' => 'Thomas Schmitt',
                'subject' => 'Problème avec l\'API',
                'date' => 'Hier',
            ],
        ];
    }

    private function getActiveMembers(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'John Doe',
                'initials' => 'JD',
                'lastActive' => 'En ligne',
            ],
            [
                'id' => 2,
                'name' => 'Marie Keller',
                'initials' => 'MK',
                'lastActive' => 'Il y a 5 min',
            ],
            [
                'id' => 3,
                'name' => 'Alex Lefebvre',
                'initials' => 'AL',
                'lastActive' => 'Il y a 15 min',
            ],
            [
                'id' => 4,
                'name' => 'Thomas Schmitt',
                'initials' => 'TS',
                'lastActive' => 'Il y a 30 min',
            ],
            [
                'id' => 5,
                'name' => 'Patricia Durand',
                'initials' => 'PD',
                'lastActive' => 'Il y a 1h',
            ],
        ];
    }
}
