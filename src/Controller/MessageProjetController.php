<?php

namespace App\Controller;
use App\Repository\ForumProjetRepository;
use App\Repository\MessageProjetRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class MessageProjetController extends AbstractController
{
    #[Route('/message_p/create/{id_forum}/{id_membre}', name: 'app_message_projet_create', methods: ['POST'])]
    public function create(
        int $id_forum, int $id_membre, Request $request, ForumProjetRepository $forumProjetRepository, MessageProjetRepository $messageProjetRepository): Response
    {
        $message = $request->request->get('message');
        $date = (new \DateTime())->format('Y-m-d');
        $messageProjetRepository->createMessageProjet($id_forum, $id_membre, $message, $date);
        // Rediriger vers la liste des forums ou une page de confirmation
        return $this->redirectToRoute('app_forums_show_p', ['id' => $id_forum]); // Redirection vers la liste des forums ou une autre page
    }
}
