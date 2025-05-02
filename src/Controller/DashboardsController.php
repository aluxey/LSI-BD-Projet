<?php

namespace App\Controller;

use App\Repository\MembreRepository;
use App\Repository\ProjetRepository;
use App\Repository\EvenementRepository;
use App\Repository\ForumEvenementRepository;
use App\Repository\ForumProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DashboardsController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(
        MembreRepository $membreRepository,
        ProjetRepository $projetRepository,
        EvenementRepository $evenementRepository,
        ForumEvenementRepository $forumEvenementRepository,
        ForumProjetRepository $forumProjetRepository
    ): Response {

        $membres = $membreRepository->findAll();
        $projets = $projetRepository->findAll();
        $events = $evenementRepository->findAll();
        $fevents = $forumEvenementRepository->findAll();
        $fprojets = $forumProjetRepository->findAll();

        return $this->render('dashboard/index.html.twig', [
            'membres' => $membres,
            'projets' => $projets,
            'events' => $events,
            'forumsEvent' => $fevents,
            'forumsProjet' => $fprojets,
        ]);
    }
}
