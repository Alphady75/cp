<?php

namespace App\Form;

use App\Entity\Convertis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('instagram', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Instagram', 'class' => 'border-0 bg-transparent pl-0'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('indicatif', TextType::class, [
                'label' => false,
                'mapped' => false,
                'attr' => ['placeholder' => '41', 'class' => 'form-control pl-0 pr-0 text-center border-0'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('numero', TextType::class, [
                'label' => false,
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
