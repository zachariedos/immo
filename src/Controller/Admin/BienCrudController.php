<?php

namespace App\Controller\Admin;

use App\Entity\Bien;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BienCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bien::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('categorie', 'Catégorie'),
            TextField::new('type', 'Type'),
            DateTimeField::new('created_at', 'Date de création'),
            DateTimeField::new('updated_at', 'Date de modification'),
            ImageField::new('image_name', 'Photo du bien')
                ->onlyOnIndex()
                ->setBasePath('/images/biens/'),
            ImageField::new('imageFile', 'Photo du bien')->setFormType(VichImageType::class)->hideOnIndex(),
            TextEditorField::new('description'),
            NumberField::new('prix'),
        ];
    }
}
