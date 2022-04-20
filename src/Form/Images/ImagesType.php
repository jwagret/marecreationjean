<?php

namespace App\Form\Images;

use App\Entity\Images;
use App\Entity\Produits;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\File;

class ImagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image_nom', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
            ])
            ->add('image_chemin', FileType::class, [
                'label' => 'Votre image produit (fichiers images uniquement png)',
                'required' => true,
//                'multiple' => true,
                'mapped' => false,
                'attr' => [
                    'class' => 'form-control mb-3',
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            // 'image/gif',
                            // 'image/jpeg',
                            // 'image/jpg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'SVP charger une image valide (png)'
                    ])
                ]
            ])
            ->add('produit', EntityType::class, [
                'mapped' => true,
                'class' => Produits::class,
                'choice_label' => 'produit_nom',
                'attr' => [
                    'class' => 'form-select mb-3',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Images::class,
            'attr' => [
                'novalidate' => 'novalidate' //Désactiver la validation côté client (html5)
            ]
        ]);
    }
}
