<?php

namespace App\Controller;
use App\Repository\ForumEvenementRepository;
use App\Repository\ForumProjetRepository;
use App\Repository\MessageEvenementRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class ForumsController extends AbstractController
{
    #[Route('/forums', name: 'app_forums')]
    public function index(ForumEvenementRepository $forumEvenementRepository, ForumProjetRepository $forumProjetRepository): Response
    {
        $forums = $forumEvenementRepository->findAll();
        $projets = $forumProjetRepository->findAll();
        $is_register = false;
        return $this->render('forums/index.html.twig', [
            'forums_e' => $forums,
            'forums_p' => $projets
        ]);
    }

    #[Route('/forum/{id}', name: 'app_forums_show')]
    public function show(
        int $id,
        ForumEvenementRepository $forumEvenementRepository,
        MessageEvenementRepository $messageEvenementRepository
    ): Response
    {
        $forum = $forumEvenementRepository->findByEvenementIdField($id);
        $messages = $messageEvenementRepository->findMessagesByForumEvenementIdField($id);
        return $this->render('forums/show.html.twig', [
            'forum' => $forum,
            'messages' => $messages
        ]);
    }


    #[Route('/forum/{id}/delete', name: 'app_forums_delete', methods: ['POST'])]
    public function delete(int $id, ForumEvenementRepository $forumEvenementRepository): Response
    {
        $forumEvenementRepository->deleteForumEvenement($id);
        return $this->redirectToRoute('app_forums');
    }

    #[Route('/forum/create/{id}', name: 'app_forum_event_create', methods: ['POST'])]
    public function create(
        int $id, Request $request, ForumEvenementRepository $forumEvenementRepository): Response
    {
        $titre = $request->request->get('project_name');
        $forumEvenementRepository->createForumEvenement($titre, $id);
        // Rediriger vers la liste des forums ou une page de confirmation
        return $this->redirectToRoute('app_forum_list'); // Redirection vers la liste des forums ou une autre page
    }
}
