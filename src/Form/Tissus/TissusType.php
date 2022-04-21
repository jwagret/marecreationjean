<?php

namespace App\Form\Tissus;

use App\Entity\Tissus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TissusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tissu_nom', TextType::class, [
                'label' => "Nom du tissus",
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('tissus_designation', TextareaType::class, [
                'required' => true,
                'label' => "Désignation du tissus",
                'attr' => [
                    'class' => 'form-control mb-3'
                ]
            ])
            ->add('tissu_tarif', NumberType::class, [
                'required' => false,
                'label' => "prix du tissus (€/metre)",
                'attr' => [
                    'class' => 'form-control mb-3',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tissus::class,
            'attr' => [
                'novalidate' => 'novalidate' //Désactiver la validation côté client (html5)
            ]
        ]);
    }
}
