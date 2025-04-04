<?php

namespace App\Controller;

use App\Repository\MembreRepository;
use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(
        MembreRepository $membreRepository,
        ProjetRepository $projetRepository
    ): Response {
        $membres = $membreRepository->findAll();
        $projets = $projetRepository->findAll();

        return $this->render('dashboard/index.html.twig', [
            'membres' => $membres,
            'projets' => $projets,
        ]);
    }
}

