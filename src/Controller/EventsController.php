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
        return $this->render('events/index.html.twig', [
            'controller_name' => 'EventsController',
            'is_register' => $is_register
        ]);
    }
}
