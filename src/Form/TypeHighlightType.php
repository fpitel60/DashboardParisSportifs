<?php

namespace App\Form;

use App\Entity\Sport;
use App\Entity\TypeHighlight;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class TypeHighlightType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Fait marquant', 'required' => false))
            ->add('sign', ChoiceType::class, array(
                'choices' => [
                    'Plus' => '+',
                    'Moins' => '-',
                ],
                'required' => false,
                'label' => 'Plus/Moins'
                ))
            ->add('nombre', NumberType::class, array('label' => 'Nombre', 'required' => false))
            ->add('sport', EntityType::class, array(
                'class' => Sport::class,
                'choice_label' => 'name',
                'label' => 'Sélectionnez le sport appartenant au type de fait marquant',
                'multiple' => false,
                'required' => false
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypeHighlight::class,
        ]);
    }
}
