<?php

namespace App\Form\Transporteur;

use App\Entity\Transporteurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransporteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('transporteur_nom', TextType::class, [
                'label' => "Nom du transporteur",
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('transporteur_prix', NumberType::class, [
                'required' => false,
                'label' => "prix du transporteur ",
                'attr' => [
                    'class' => 'form-control mb-3',
                ]
            ])
            ->add('isActif', CheckboxType::class, [
                'label' => 'Activer le transporteur (transporteur par défaut)',
                'attr' => [
                    'class' => 'form-check-input mb-3',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transporteurs::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ]
        ]);
    }
}
