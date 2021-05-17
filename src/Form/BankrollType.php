<?php

namespace App\Form;

use App\Entity\Bankroll;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class BankrollType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nom de votre bankroll', 'required' => true))
            ->add('visibility', ChoiceType::class, array(
                'choices' => [
                    'Public' => 'Public',
                    'Privé' => 'Privé',
                ],
                'required' => true,
                'label' => 'Public/Privé (Visibilité sur l\'évolution de votre bankroll (ROI, ROC, bénéfices, nombre de paris))'
            ))
            ->add('startBankroll', NumberType::class, array('label' => 'Bankroll de départ', 'required' => true))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bankroll::class,
        ]);
    }
}
