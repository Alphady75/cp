<?php

namespace App\Form;

use App\Entity\SearchVisites;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchVisiteType extends AbstractType
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
         ])
         /*->add('categories', EntityType::class, [
            'label' => false,
            'class' => Categorie::class,
            'choice_label'  => 'name',
            'placeholder' => 'Catégorie',
            //'autocomplete' => true,
            'expanded' => true,
            'required' => false,
            'multiple' => true,
         ])*/;
   }

   public function configureOptions(OptionsResolver $resolver): void
   {
      $resolver->setDefaults([
         'data_class' => SearchVisites::class,
         'method' => 'GET',
         'csrf_protection' => false,
      ]);
   }

   public function getBlockPrefix()
   {
      return '';
   }
}
