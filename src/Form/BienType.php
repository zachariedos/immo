<?php

namespace App\Form;

use App\Entity\Bien;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;


class BienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description', CKEditorType::class)
            ->add('categorie', ChoiceType::class, [
                'choices'  => [
                    'Location' => 'location',
                    'Vente' => 'vente',
                ]
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Photo du bien',
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => true,
                'asset_helper' => true,
            ])
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Maison' => 'maison',
                    'Appartement' => 'appartement',
                    'Villa' => 'villa',
                ]
            ])
            ->add('prix');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bien::class,
        ]);
    }
}
