<?php

namespace App\Form\Client;

use App\Entity\Clients;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client_nom', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre nom'
                    ])
                ]
            ])
            ->add('client_prenom', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre prénom'
                    ])
                ]
            ])
            ->add('pseudo', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new NotBlank([
                         'message' => 'Veuillez entrer votre pseudo'
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'mapped' => false,
                'constraints' => [
                    new Email([
                        'message' => "L'adresse email doit, par exemple, être de la forme : monemail@hotmail.fr"
                    ]),
                    new Length(['min' => 2, 'max' => 60])
                ],
                'attr' => [
                    'class' => 'form-control',
                    'label' => 'Votre email',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Clients::class,
            'attr' => [
                'novalidate' => 'novalidate' //Désactiver la validation côté client (html5)
            ]
        ]);
    }
}
