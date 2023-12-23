<?php

namespace App\Form;

use App\Entity\SearchConvertis;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class SearchType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options): void
   {
      $builder
         ->add('instagram', TextType::class, [
            'label' =>  'Instagram',
            'required'  =>  false,
            'attr'  =>  [
               'placeholder'   =>  '@intagram, Téléphone', 'class' =>  'rounded border-0 pl-0'
            ]
         ])
         ->add('listeAttente', ChoiceType::class, [
            'label' =>  false,
            'placeholder' =>  "--Inscriptions/Liste d'attente--",
            'required'  =>  false,
            'choices'  =>  [
               'Inscriptions' => 0,
               "Liste d'attente" => 1,
            ],
            'attr'  =>  [
               'placeholder'   =>  "Liste d'attente", 'class' =>  'rounded'
            ]
         ])
         ->add('minDate', DateType::class, [
            'widget' => 'single_text',
            'required' => false,
            'label' => false,
            'attr'  =>  [
               'class' =>  'rounded'
            ]
         ])
         ->add('maxDate', DateType::class, [
            'widget' => 'single_text',
            'required' => false,
            'label' => false,
            'attr'  =>  [
               'class' =>  'rounded'
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
         'data_class' => SearchConvertis::class,
         'method' => 'GET',
         'csrf_protection' => false,
      ]);
   }

   public function getBlockPrefix()
   {
      return '';
   }
}
