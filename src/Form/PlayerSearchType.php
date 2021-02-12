<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\PlayerSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PlayerSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, array(
                'label' => false, 
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Prénom' 
                )
            ))
            ->add('lastName', TextType::class, array(
                'label' => false, 
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Nom' 
                )
            ))
            ->add('team', EntityType::class, array(
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => false,
                'multiple' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Equipe' 
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlayerSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
}