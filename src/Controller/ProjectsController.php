<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectsController extends AbstractController
{
    #[Route('/projects', name: 'app_projects')]
    public function index(): Response
    {
        $is_register = false;
        return $this->render('projects/index.html.twig', [
            'controller_name' => 'ProjectsController',
            'is_register' => $is_register
        ]);
    }
}
