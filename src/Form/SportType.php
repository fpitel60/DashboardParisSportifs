<?php

namespace App\Form;

use App\Entity\Sport;
use App\Entity\League;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Sport', 'required' => false))
            ->add('leagues', EntityType::class, array(
                'class' => League::class,
                'choice_label' => 'name',
                'label' => 'Sélectionnez les ligues appartenant au sport',
                'multiple' => true,
                'required' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sport::class,
        ]);
    }
}
