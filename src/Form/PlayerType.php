<?php

namespace App\Form;

use App\Entity\Team;
use App\Entity\Player;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PlayerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, array('label' => 'Prénom', 'required' => false))
            ->add('lastName', TextType::class, array('label' => 'Nom', 'required' => false))
            ->add('team', EntityType::class, array(
                'class' => Team::class,
                'choice_label' => 'name',
                'label' => 'Sélectionnez l équipe du joueur',
                'multiple' => false,
                'required' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
