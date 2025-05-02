<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectsController extends AbstractController
{
    #[Route('/projects', name: 'app_projects')]
    public function index(
        ProjetRepository $projetRepository): Response
    {
        $projets = $projetRepository->findAll();

        return $this->render('projects/index.html.twig', [
            'projets' => $projets,
        ]);
    }

    #[Route('/project/{id}', name: 'app_project_show')]
    public function show(int $id,
        ProjetRepository $projetRepository): Response
    {
        $projet = $projetRepository->findOneByIdField($id);
        $membres = $projetRepository->findMembresByProjetId($id);

        return $this->render('projects/show.html.twig', [
            'projet' => $projet,
            'membres' => $membres
        ]);
    }


    #[Route('/project/delete/{id}', name: 'app_project_delete', methods: ['POST'])]
    public function delete(int $id, ProjetRepository $projetRepository): Response
    {
        $rowsAffected = $projetRepository->deleteProjet($id);
        return $this->redirectToRoute('app_projects');
    }
}
