<?php

namespace App\Form;

use App\Entity\League;
use App\Entity\TeamSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TeamSearchType extends AbstractType
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
            ->add('league', EntityType::class, array(
                'class' => League::class,
                'choice_label' => 'name',
                'label' => false,
                'multiple' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Ligue' 
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TeamSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
}