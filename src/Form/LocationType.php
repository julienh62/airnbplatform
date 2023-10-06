<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;



class LocationType extends AbstractType
{

    private EntityManagerInterface $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {   
        $builder    
            ->addEventListener(
                FormEvents::SUBMIT, 
               function(FormEvent $event){
                $location = $event->getData();
                $form=$event->getForm();
              
                $conn = $this->em->getConnection();
                $sql = 'SELECT *
                FROM spec_villes_france_free
                WHERE ville_nom_simple = :param';
                $request = $conn->prepare($sql);
                $resultSet  = $request->executeQuery(['param' => $location->getCity()]);
                $result = $resultSet->fetchAssociative();
                
                if(!$result){
                    $form->get("city")->addError(new FormError("La ville n'existe pas"));
                }else{
                    $location->setLongitude($result['ville_longitude_deg']);
                    $location->setLatitude($result['ville_latitude_deg']);
                    // dd($location);
                }
               }
            )
            ->add('address')
            ->add('dateStart', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('dateEnd', DateType::class, [
                'widget' => 'single_text',
            ])
        
        /*    ->addEventListener(
                FormEvents::SUBMIT, 
                function(FormEvent $event){
                 // $form = $event->getForm();
                //ajout
                //$form->add('name_champ');
                  //suppression
                  if($locationType = BoatType | HouseType | AppartType | TreeHouseType ) {
                    $form->remove('address');
                  }
                
                }
            ) */
          
            ->add('nbrRoom')
            ->add('description')
            ->add('nightPrice')
            ->add('area')
           // ->add('ville_latitude')
           // ->add('ville_longitude')
            ->add('city', TextType::class,  ['attr' => ['list' => 'cities', "class" => "city"]]);
            
   
        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }


   





}
