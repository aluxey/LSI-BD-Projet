<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ForumsController extends AbstractController
{
    #[Route('/forums', name: 'app_forums')]
    public function index(): Response
    {
        $is_register = false;
        return $this->render('forums/index.html.twig');
    }

    #[Route('/forum/{id}', name: 'app_forums_show')]
    public function show(): Response
    {
        return $this->render('forums/show.html.twig');
    }


    #[Route('/forum/{id}/delete', name: 'app_forums_delete', methods: ['POST'])]
    public function delete(int $id): Response
    {
        return $this->redirectToRoute('app_forums');
    }
}
