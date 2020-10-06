<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use App\Entity\Bien;
use App\Entity\User;

class DashboardController extends AbstractDashboardController
{

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Home', 'fa fa-home'),
            MenuItem::linkToCrud('Biens', 'fa fa-home', Bien::class),
            MenuItem::linkToRoute('Biens', 'fa fa-home', 'bien_index'),
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
