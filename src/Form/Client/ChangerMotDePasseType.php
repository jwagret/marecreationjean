<?php

namespace App\Form\Client;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangerMotDePasseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPasse', PasswordType::class, [
                'mapped' => false,
                'label' => 'Mot de passe actuel',
                'constraints' => [
                    new NotBlank([
                        'message' => "Saisir l'ancien mot de passe"
                    ]),
                    new Length([
                        'min' => 6, 'minMessage' => 'Vous devez entrer au moins {{ limit }} caractères',
                        'max' => 4096
                    ])
                ],
                'attr' => [
                    'class' => 'form-control mb-2'
                ]
            ])
            ->add('password',RepeatedType::class, [
                'mapped'=> false,
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Nouveau Mot de Passe',
                    'attr' => [
                        'class' => 'form-control mb-2'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation',
                    'attr' => [
                        'class' => 'form-control mb-2'
                    ]
                ],
                'invalid_message' => 'Les deux mots de passe doivent être identiques',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Saisir le mot de passe pour valider',
                    ]),
                    new Length(['min' => 6, 'minMessage' => 'Vous devez entrer au moins {{ limit }} caractères', 'max' => 4096])
                ],
                'attr' => [
                    'autocomplete' => 'new-password'
                ],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => [
                'novalidate' => 'novalidate' //Désactiver la validation côté client (html5)
            ]
        ]);
    }
}
