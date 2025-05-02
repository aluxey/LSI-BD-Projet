<?php

namespace App\Controller;
use App\Repository\EvenementRepository;
use App\Repository\ForumEvenementRepository;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EventsController extends AbstractController
{
    #[Route('/events', name: 'app_events')]
    public function index(EvenementRepository $evenementRepository): Response
    {
        $events = $evenementRepository->findAll();
        return $this->render('events/index.html.twig', [
            'events' => $events
        ]);
    }
    

    #[Route('/event/{id}', name: 'app_event_show', requirements: ['id' => '\d+'])]
    public function show(int $id, EvenementRepository $evenementRepository, ForumEvenementRepository $forumEvenementRepository): Response
    {
        $event = $evenementRepository->findOneByIdField($id);
        $membres = $projetRepository->findMembresByProjetId($id);
        $forums = $forumEvenementRepository->findByProjetIdField($id);
        return $this->render('events/show.html.twig', [
            'event' => $event,
            'membres' => $membres,
            'forums' => $forums
        ]);
    }


    #[Route('/event/{id}/delete', name: 'app_event_delete', methods: ['POST'])]
    public function delete(int $id, EvenementRepository $evenementRepository): Response
    {
        $evenementRepository->deleteEvenement($id);
        return $this->redirectToRoute('app_events');
    }

    #[Route('/event/create', name: 'app_event_create', methods: ['POST'])]
    public function create(Request $request, EvenementRepository $evenementRepository): Response
    {
        $name = $request->request->get('event_name');
        $description = $request->request->get('event_description');
        $date = $request->request->get('event_date');
        $evenementRepository->createEvenement($name, $description, $date);

        return $this->redirectToRoute('app_events');
    }
}
