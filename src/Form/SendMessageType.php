<?php

namespace App\Form;

use App\Entity\Convertis;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class SendMessageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contenu', TextareaType::class, [
                'label' => "Envoyez ce message",
                'attr' => ['rows' => 2, 'placeholder' => "Envoyer un message aux inscrits..."],
                'constraints' => new NotBlank([
                    'message' => 'Ecrivez un message...'
                ])
            ])
            ->add('listeAttente', ChoiceType::class, [
                'label' =>  false,
                'placeholder' =>  "A toute la liste",
                'required'  =>  false,
                'expanded' => true,
                'choices'  =>  [
                    'Aux inscripts' => 0,
                    "A la liste d'attente" => 1,
                ],
                'attr'  =>  [
                    'placeholder'   =>  "Liste d'attente", 'class' =>  'ml-3'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
