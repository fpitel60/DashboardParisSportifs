<?php

namespace App\Form;

use App\Entity\Montante;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class MontanteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateStart', DateType::class, array(
                "label" => 'Date du début de la montante',
                "widget" => 'single_text',
                "format" => 'yyyy-MM-dd',
                "data" => new \DateTime()
            ))
            ->add('nbPalier', NumberType::class, array('label' => 'Nombre de paliers', 'required' => true))
            ->add('miseStart', NumberType::class, array('label' => 'Mise de départ', 'required' => true))
            ->add('objectif', NumberType::class, array('label' => 'Objectif de la montante', 'required' => true))
            ->add('resultMontante', NumberType::class, array('label' => 'Résultat de la montante', 'required' => false))
            ->add('gain', NumberType::class, array('label' => 'Gain de la montante', 'required' => false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Montante::class,
        ]);
    }
}
