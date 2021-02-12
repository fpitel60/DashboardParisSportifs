<?php

namespace App\Form;

use App\Entity\TypeBetSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TypeBetSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => false, 
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Nom' 
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypeBetSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
}