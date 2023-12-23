<?php

namespace App\Form;

use App\Entity\Convertis;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class MessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            /*->add('convertis', EntityType::class, [
                'label' => 'Téléphone',
                'class' => Convertis::class,
                'choice_label' => 'numero',
                'mapped' => false,
                'multiple' => true,
                'autocomplete' => true,
                'attr' => ['class' => 'p-0 m-0 h-100 border-0 bg-white'],
            ])*/
            ->add('contenu', TextareaType::class, [
                'label' => "Envoyez ce message aux convertis",
                'attr' => ['rows' => 2, 'placeholder' => "Envoyer un message aux inscrits..."],
                'constraints' => new NotBlank([
                    'message' => 'Ecrivez un message...'
                ])
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
