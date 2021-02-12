<?php

namespace App\Form;

use App\Entity\Game;
use App\Entity\Team;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, array(
                'label' => 'Date',
                "widget" => 'single_text',
                "format" => 'yyyy-MM-dd',
                "data" => new \DateTime()
            ))
            ->add('homeTeam', EntityType::class, array(
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => 'Sélectionnez l équipe domicile',
                'multiple' => false,
                'required' => true
            ))
            ->add('foreignTeam', EntityType::class, array(
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => 'Sélectionnez l équipe extérieure',
                'multiple' => false,
                'required' => true
            ))
            ->add('score', TextType::class, array('label' => 'Score', 'required' => false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
