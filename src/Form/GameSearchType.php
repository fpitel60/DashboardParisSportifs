<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\GameSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class GameSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, array(
                'label' => false,
                'required' => false,
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'data' => new \DateTime()
            ))
            ->add('homeTeam', EntityType::class, array(
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => false,
                'multiple' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Equipe domicile' 
                )
            ))
            ->add('foreignTeam', EntityType::class, array(
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => false,
                'multiple' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Equipe extérieure' 
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GameSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
}
