<?php

namespace App\Controller;
use App\Repository\ForumEvenementRepository;
use App\Repository\MessageEvenementRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class MessageEventController extends AbstractController
{
    #[Route('/message_e/create/{id_forum}/{id_membre}', name: 'app_message_event_create', methods: ['POST'])]
    public function create(
        int $id_forum, int $id_membre, Request $request, ForumEvenementRepository $forumEvenementRepository, MessageEvenementRepository $messageEvenementRepository): Response
    {
        $message = $request->request->get('message');
        $date = (new \DateTime())->format('Y-m-d');
        $messageEvenementRepository->createMessageEvenement($id_forum, $id_membre, $message, $date);
        // Rediriger vers la liste des forums ou une page de confirmation
        return $this->redirectToRoute('app_forums_show', ['id' => $id_forum]); // Redirection vers la liste des forums ou une autre page
    }
}
