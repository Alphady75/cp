<?php

namespace App\Form;

use App\Entity\Convertis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EditConvertisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('instagram', TextType::class, [
                'label' => 'Instagram',
                'attr' => ['placeholder' => 'Instagram', 'class' => ''],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('imageFile', VichImageType::class, [
                'label' =>  'Photo (Format: png, jpg et jpeg)',
                'allow_delete' =>  false,
                'download_label'     =>  false,
                'image_uri'     =>  false,
                'download_uri'     =>  false,
                'imagine_pattern'   =>  'large_avatar',
                'attr' => ['class' => ''],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide'
                    ])
                ]
            ])
            ->add('indicatif', TextType::class, [
                'label' => 'Indicatif',
                'mapped' => false,
                'attr' => ['placeholder' => '+41', 'class' => ''],
                'require' => false,
            ])
            ->add('numero', TextType::class, [
                'label' => 'Téléphone',
                'attr' => ['placeholder' => 'Téléphone', 'class' => 'radius'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Convertis::class,
        ]);
    }
}
