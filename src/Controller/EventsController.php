<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EventsController extends AbstractController
{
    #[Route('/events', name: 'app_events')]
    public function index(): Response
    {
        $is_register = false;
        return $this->render('events/index.html.twig');
    }

    #[Route('/event/{id}', name: 'app_event_show')]
    public function show(): Response
    {
        return $this->render('events/show.html.twig');
    }


    #[Route('/event/{id}/delete', name: 'app_event_delete', methods: ['POST'])]
    public function delete(int $id): Response
    {
        return $this->redirectToRoute('app_events');
    }
}
