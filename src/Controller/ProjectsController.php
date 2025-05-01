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
        return $this->render('projects/show.html.twig');
    }


    #[Route('/project/{id}/delete', name: 'app_project_delete', methods: ['POST'])]
    public function delete(int $id): Response
    {
        return $this->redirectToRoute('app_projects');
    }
}
