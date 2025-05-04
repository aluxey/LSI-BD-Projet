<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use App\Repository\ForumProjetRepository;
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

    #[Route('/project/create', name: 'app_project_create', methods: ['POST'])]
    public function create(Request $request, ProjetRepository $projetRepository): Response
    {
        $name = $request->request->get('project_name');
        $description = $request->request->get('project_description');
        $date = $request->request->get('project_deadline');
        $rowsAffected = $projetRepository->createProjet($name, $description, $date);

        return $this->redirectToRoute('app_projects');
    }

    #[Route('/project/{id}', name: 'app_project_show')]
    public function show(int $id,
        ProjetRepository $projetRepository, ForumProjetRepository $forumProjetRepository): Response
    {
        $projet = $projetRepository->findOneByIdField($id);
        $membres = $projetRepository->findMembresByProjetId($id);
        $forums = $forumProjetRepository->findByProjetIdField($id);

        return $this->render('projects/show.html.twig', [
            'projet' => $projet,
            'membres' => $membres,
            'forums' => $forums
        ]);
    }


    #[Route('/project/delete/{id}', name: 'app_project_delete', methods: ['POST'])]
    public function delete(int $id, ProjetRepository $projetRepository): Response
    {
        $rowsAffected = $projetRepository->deleteProjet($id);
        return $this->redirectToRoute('app_projects');
    }

    #[Route('/project/{id}/update', name: 'app_project_update', methods: ['POST'])]
    public function update(int $id, Request $request, ProjetRepository $projetRepository): Response
    {
        $name = $request->request->get('project_name');
        $description = $request->request->get('project_description');
        $date = $request->request->get('project_deadline');
        $projetRepository->updateProjet($id, $name, $description, $date);

        return $this->redirectToRoute('app_project_show', ['id' => $id]);
    }
}
