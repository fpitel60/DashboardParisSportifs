<?php

namespace App\Form;

use App\Entity\League;
use App\Entity\Sport;
use App\Entity\Country;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LeagueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Ligue', 'required' => false))
            ->add('sport', EntityType::class, array(
                'class' => Sport::class,
                'choice_label' => 'name',
                'label' => 'Sélectionnez le sport de la ligue',
                'multiple' => false,
                'required' => false
            ))
            ->add('country', EntityType::class, array(
                'class' => Country::class,
                'choice_label' => 'name',
                'label' => 'Sélectionnez le pays de la ligue',
                'multiple' => false,
                'required' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => League::class,
        ]);
    }
}
