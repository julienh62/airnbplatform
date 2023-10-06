<?php

namespace App\Form;

use App\Entity\RoomDetail;
use App\Form\LocationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomDetailType extends LocationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
        $builder
          
            ->add('quantity')
            ->add('bed')
            
           
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RoomDetail::class,
        ]);
    }
}
