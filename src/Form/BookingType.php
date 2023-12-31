<?php

namespace App\Form;

use App\Entity\Booking;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           // ->add('dateStart')
            ->add('dateStart', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateEnd', DateType::class, [
                'widget' => 'single_text',
            ])
         //   ->add('dateEnd')
            ->add('participant')
            
            //->add('user')
           // ->add('location')
          // ->add('location')
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
