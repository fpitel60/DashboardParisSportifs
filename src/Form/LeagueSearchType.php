<?php

namespace App\Form;

use App\Entity\Sport;
use App\Entity\Country;
use App\Entity\LeagueSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LeagueSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => false, 
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Nom' 
                )
            ))
            ->add('sport', EntityType::class, array(
                'class' => Sport::class,
                'choice_label' => 'name',
                'label' => false,
                'multiple' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Sport' 
                )
            ))
            ->add('country', EntityType::class, array(
                'class' => Country::class,
                'choice_label' => 'name',
                'label' => false,
                'multiple' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Pays' 
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LeagueSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
}