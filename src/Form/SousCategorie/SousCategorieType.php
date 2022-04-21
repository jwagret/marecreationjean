<?php

namespace App\Form\SousCategorie;

use App\Entity\Categories;
use App\Entity\SousCategories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SousCategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sousCategorie_nom', TextType::class, [
                'label' => "Nom de la sous-catégorie",
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('categorie', EntityType::class, [
                'label' => "Choisir la catégorie correspondante ",
                'mapped'=> true,
                'class' => Categories::class,
                'choice_label' => 'categorie_nom',
                'attr' => [
                    'class' => 'form-select mb-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SousCategories::class,
            'attr' => [
                'novalidate' => 'novalidate' //Désactiver la validation côté client (html5)
            ]
        ]);
    }
}
