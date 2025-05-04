<?php

namespace App\Controller;
use App\Repository\ForumProjetRepository;
use App\Repository\ForumEvenementRepository;
use App\Repository\MessageProjetRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ForumController extends AbstractController
{
    #[Route('/forums_all', name: 'app_forums_all')]
    public function index(ForumProjetRepository $forumProjetRepository, ForumEvenementRepository $forumEvenementRepository): Response
    {
        $forums_p = $forumProjetRepository->findAll();
        $forums_e = $forumEvenementRepository->findAll();
        $is_register = false;
        return $this->render('forums_all/index.html.twig', [
            'forumsProjet' => $forums_p,
            'forumsEvent' => $forums_e
        ]);
    }
}
