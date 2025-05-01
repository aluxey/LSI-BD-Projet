<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MembreRepository;

final class HomeController extends AbstractController
{
    private $membreRepository;

    public function __construct(MembreRepository $membreRepository)
    {
        $this->membreRepository = $membreRepository;
    }
    
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);

        // Appel de la méthode findByNameField du repository pour récupérer les membres
        //$membres = $this->membreRepository->findByNameField('test'); // Remplace 'nom_recherche' par le nom que tu veux chercher

        // Retourne la réponse avec les données des membres envoyées à Twig
        //return $this->render('home/index2.html.twig', [
            //'controller_name' => 'HomeController',
            //'membres' => $membres, // On passe les résultats à Twig
        //]);
    }
}