<?php

namespace App\Form\Reductions;

use App\Entity\Produits;
use App\Entity\Reductions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReductionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reduction_reference', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('reduction_designation', TextareaType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('reduction_pourcentage', NumberType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('reduction_montant', NumberType::class, [
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('anneeReductions', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('produits', EntityType::class, [
                'class' => Produits::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reductions::class,
        ]);
    }
}
