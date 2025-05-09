<?php

namespace App\Controller;
use App\Repository\ForumProjetRepository;
use App\Repository\MessageProjetRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class ForumProjetController extends AbstractController
{
    #[Route('/forums_p', name: 'app_forums_p')]
    public function index(ForumProjetRepository $forumProjetRepository): Response
    {
        $forums = $forumProjetRepository->findAll();
        $is_register = false;
        return $this->render('forums_p/index.html.twig', [
            'forums' => $forums
        ]);
    }

    #[Route('/forum_p/create/{id}', name: 'app_forum_projet_create', methods: ['POST'])]
    public function create(
        int $id, Request $request, ForumProjetRepository $forumProjetRepository): Response
    {
        $titre = $request->request->get('forum_name');
        $forumProjetRepository->createForumProjet($titre, $id);
        // Rediriger vers la liste des forums ou une page de confirmation
        return $this->redirectToRoute('app_project_show', ['id' => $id]); // Redirection vers la liste des forums ou une autre page
    }

    #[Route('/forum_p/{id}', name: 'app_forums_show_p')]
    public function show(
        int $id,
        ForumProjetRepository $forumProjetRepository,
        MessageProjetRepository $messageProjetRepository
    ): Response
    {
        $forum = $forumProjetRepository->findById($id);
        $messages = $messageProjetRepository->findMessagesByForumProjetIdField($id);
        return $this->render('forums_p/show.html.twig', [
            'forum' => $forum,
            'messages' => $messages
        ]);
    }


    #[Route('/forum_p/{id}/delete', name: 'app_forums_p_delete', methods: ['POST'])]
    public function delete(int $id, ForumProjetRepository $forumProjetRepository): Response
    {
        $forumProjetRepository->deleteForumProjet($id);
        return $this->redirectToRoute('app_projects');
    }
}
