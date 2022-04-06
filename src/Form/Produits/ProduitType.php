<?php

namespace App\Form\Produits;

use App\Entity\Categories;
use App\Entity\Produits;
use App\Entity\Reductions;
use App\Entity\Tissus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('produit_reference', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('produit_nom', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('produit_designation', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('produit_prix', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control w-50 mb-3',
                ],
            ])
            ->add('is_produit_vendu', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check mb-3',
                ],
            ])
            ->add('categorie', EntityType::class, [
                'mapped' => true,
                'class' => Categories::class,
                'attr' => [
                    'class' => 'form-select mb-3',
                ],
                'choice_label' => function ($categorie) {
                    return $categorie->getCategorieNom();
                }
            ])
            ->add('reductions', EntityType::class, [
                'mapped' => false,
                'class' => Reductions::class,
                'attr' => [
                    'class' => 'form-select mb-3',
                ],
                'choice_label' => function ($reduction) {
                    return $reduction->getReductionDesignation();
                }
            ])
            ->add('tissuses', EntityType::class, [
                'mapped' => false,
                'class' => Tissus::class,
                'attr' => [
                    'class' => 'form-select mb-3',
                ],
                'choice_label' => function ($tissus) {
                    return $tissus->getTissuNom();
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produits::class,
        ]);
    }
}
