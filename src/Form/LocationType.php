<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address')
            ->add('nbrRoom')
            ->add('description')
            ->add('nightPrice')
            ->add('area')
            ->add('city')
         /*  ->add('typeLocation', ChoiceType::class, [
                'choices' => [
                    'Type 1' => 'Appart', // 
                    'Type 2' => 'Boat', // 
                    'Type 3' => 'House', // 
                    'Type 4' => 'TreeHouse', // 
                ],
                'label' => 'Choisir le type de Location',
            ])*/
        ;
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
