<?php

namespace App\Form\Adresse;

use App\Entity\Adresses;
use App\Entity\Clients;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdresseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresse_numero', TextType::class, [
                'required' => true,
                'label' => 'Numéro',
                'attr' => [
                    'class' => 'form-control w-auto ',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez indiquer un numéro'
                     ])
                ]
            ])
            ->add('adresse_rue', TextType::class, [
                'label' => 'Rue',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('adresse_codepostale', TextType::class, [
                'label' => 'Code Postale',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('adresse_ville', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('adresse_pays', CountryType::class, [
                'label' => 'Pays',
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
            ->add('adresse_type', ChoiceType::class, [
                'label' => 'Type Adresse',
                'choices' => [
                    'Particulier' => 'Particulier',
                    'Entreprise' => 'Entreprise'
                ],
                'attr' => [
                    'class' => 'form-control',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adresses::class,
            'attr' => [
                'novalidate' => 'novalidate' //Désactiver la validation côté client (html5)
            ]
        ]);
    }
}
