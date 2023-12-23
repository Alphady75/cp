<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('minDate', DateType::class, [
                'widget' => 'single_text',
                'label' => false,
                'required' => false,
                'attr'  =>  [
                    'class' =>  'rounded form-control-sm'
                ]
            ])
            ->add('maxDate', DateType::class, [
                'widget' => 'single_text',
                'label' => false,
                'required' => false,
                'attr'  =>  [
                    'class' =>  'rounded form-control-sm'
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
