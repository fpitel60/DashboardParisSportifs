<?php

namespace App\Form;

use App\Entity\BetTest;
use App\Form\GameTestType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BetTestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, array(
                'label' => 'Date',
                "widget" => 'single_text',
                "format" => 'yyyy-MM-dd HH:mm',
                'html5' => false,
                "data" => new \DateTime()
            ))
            ->add('mise', NumberType::class, array('label' => 'Mise', 'required' => true))
            ->add('resultBet', ChoiceType::class, array(
                'choices' => [
                    'Valide' => 'Valide',
                    'Perdu' => 'Perdu',
                    'Annulé' => 'Annulé',
                ],
                'required' => false,
                'label' => 'Validé/Perdu/Annulé'
            ))
            ->add('gamestest', CollectionType::class, array(
                'entry_type' => GameTestType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BetTest::class,
        ]);
    }
}
