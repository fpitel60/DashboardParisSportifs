<?php

namespace App\Form;

use App\Entity\Bookmaker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BookmakerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nom du bookmaker', 'required' => true))
            ->add('outside', ChoiceType::class, array(
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non',
                ],
                'required' => false,
                'label' => 'Bookmaker hors France (Oui/Non)'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bookmaker::class,
        ]);
    }
}
