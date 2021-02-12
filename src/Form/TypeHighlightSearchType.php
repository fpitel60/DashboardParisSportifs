<?php

namespace App\Form;

use App\Entity\Sport;
use App\Entity\TypeHighlightSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TypeHighlightSearchType extends AbstractType
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
            ->add('sport', EntityType::class, array(
                'class' => Sport::class,
                'choice_label' => 'name',
                'label' => false,
                'multiple' => false,
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Type fait marquant' 
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypeHighlightSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }
}