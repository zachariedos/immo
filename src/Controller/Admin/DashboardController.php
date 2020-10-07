<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use App\Entity\Bien;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Controller\CrudControllerInterface;

class DashboardController extends AbstractDashboardController
{

    /**
     * @Route("/admin")
     */
    public function index(): Response
    {
        // redirect to some CRUD controller
        $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

        return $this->redirect($routeBuilder->setController(BienCrudController::class)->generateUrl());
    }


    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToRoute('Accueil', 'fa fa-sign-out-alt', 'bien_index'),

            MenuItem::linkToCrud('Biens', 'fa fa-home', Bien::class),

            MenuItem::linkToCrud('Utilisateurs', 'fa fa-user', User::class),
            // ...
        ];
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            // the name visible to end users
            ->setTitle('Symfo Immo')
            // you can include HTML contents too (e.g. to link to an image)
            ->setTitle("Symfo Immo.")

            // there's no need to define the "text direction" explicitly because
            // its default value is inferred dynamically from the user locale
            ->setTextDirection('ltr');
    }
}
