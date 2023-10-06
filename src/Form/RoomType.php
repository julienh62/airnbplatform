<?php

namespace App\Form;

use App\Entity\Room;
use App\Form\LocationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class RoomType extends LocationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       
          
            $builder
               ->add('name')
               ->add('description')
                ->add('roomDetails', CollectionType::class, [
                'entry_type' => RoomDetailType::class,
                'label' => false,
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
            ])
              
            ;
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}