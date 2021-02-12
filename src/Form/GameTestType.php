<?php

namespace App\Form;

use App\Entity\GameTest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class GameTestType extends AbstractType
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
            ->add('name', TextType::class, array('label' => 'Game', 'required' => true))
            ->add('choix', TextType::class, array('label' => 'Choix du paris', 'required' => true))
            ->add('cote', NumberType::class, array('label' => 'Cote', 'required' => true))
            ->add('resultBet', ChoiceType::class, array(
                'choices' => [
                    'Valide' => 'Valide',
                    'Perdu' => 'Perdu',
                ],
                'required' => false,
                'label' => 'Validé/Perdu'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GameTest::class,
        ]);
    }
}
