<?php

namespace App\Form\Stocks;

use App\Entity\Produits;
use App\Entity\Stocks;
use App\Entity\Tissus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StocksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('stock_reference', TextType::class, [
                'label' => "Référence (st_referenceDuProduit)",
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('stock_designation', TextType::class, [
                'label' => "Désignation (nom ou la reference du produit",
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('stock_quantite', NumberType::class, [
                'required' => false,
                'label' => "quantité stocké",
                'attr' => [
                    'class' => 'form-control mb-3',
                ]
            ])
//            ->add('is_stock_rupture')
            ->add('tissu', EntityType::class,  [
                'label' => "Choisir la désignation du tissu ",
                'mapped'=> true,
                'class' => Tissus::class,
                'choice_label' => 'tissu_nom',
                'attr' => [
                    'class' => 'form-select mb-3'
                ]
            ])
            ->add('produit', EntityType::class, [
                'label' => "Choisir la référence produit ",
                'mapped'=> true,
                'class' => Produits::class,
                'choice_label' => 'produit_reference',
                'attr' => [
                    'class' => 'form-select mb-3',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stocks::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
