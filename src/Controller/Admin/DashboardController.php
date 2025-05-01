<?php

namespace App\Controller\Admin;

use App\Entity\Promo;
use App\Entity\Projet;
use App\Entity\Evenement;
use App\Entity\ForumEvenement;
use App\Entity\ForumProjet;
use App\Entity\Membre;
use App\Entity\MessageEvenement;
use App\Entity\MessageProjet;

use App\Controller\Admin\PromoCrudController;
use App\Controller\Admin\ProjetCrudController;
use App\Controller\Admin\EvenementCrudController;
use App\Controller\Admin\ForumEvenementCrudController;
use App\Controller\Admin\ForumProjetCrudController;
use App\Controller\Admin\MembreCrudController;
use App\Controller\Admin\MessageEvenementCrudController;
use App\Controller\Admin\MessageProjetCrudController;

use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin_dashboard')]
    public function index(): Response
    {
        // Si l'utilisateur a le rôle 'ROLE_ADMIN', on affiche le dashboard
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('LSI BD Projet - Admin')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Promos', 'fas fa-users', Promo::class);
        yield MenuItem::linkToCrud('Projets', 'fas fa-project-diagram', Projet::class);
        yield MenuItem::linkToCrud('Événements', 'fas fa-calendar', Evenement::class);
        yield MenuItem::linkToCrud('Forums Événements', 'fas fa-comments', ForumEvenement::class);
        yield MenuItem::linkToCrud('Forums Projets', 'fas fa-comments', ForumProjet::class);
        yield MenuItem::linkToCrud('Membres', 'fas fa-user', Membre::class);
        yield MenuItem::linkToCrud('Messages Événements', 'fas fa-envelope-open-text', MessageEvenement::class);
        yield MenuItem::linkToCrud('Messages Projets', 'fas fa-envelope', MessageProjet::class);
    }
}
