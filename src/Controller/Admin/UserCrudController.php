<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnIndex(),
            BooleanField::new('enabled', 'Activation'),
            TextField::new('username', "Nom D'utilisateur"),
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('email'),
            DateTimeField::new('lastLogin', 'Dernière connexion')->onlyOnIndex(),

        ];
    }
}
