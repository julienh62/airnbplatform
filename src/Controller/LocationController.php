<?php

namespace App\Controller;


use App\Entity\Location;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class LocationController extends AbstractController
{
    #[Route('/location', name: 'app_location')]
    public function index(LocationRepository $locationRepository): Response
    {
        $locations = $locationRepository->findAll();
        
        
        return $this->render('location/index.html.twig', [
            'locations' => $locations,          
        ]);
    }

    #[Route('/createLocationChoose', name: 'app_formChooselocation')]
    public function chooseLocationForm(): Response
    {
        return $this->render('location/chooseLocation.html.twig');
    }

   
    #[Route('/createLocation/{typeLocation}', name: 'app_createLocation')]
    public function create( Request $request, EntityManagerInterface $em, string $typeLocation): Response
    {

       $location = new ("App\\Entity\\".$typeLocation)();

     /*  if (class_exists('App\\Entity\\' . $type) && get_parent_class('App\\Entity\\' . $type) == "App\\Entity\\Location") {*/
 

       // Assurez-vous que l'utilisateur connecté est associé au location
       $location->setUser($this->getUser());
       //dd($location);

   

     $form = $this->createForm("App\\Form\\".$typeLocation."Type", $location);



     $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) { 
            


         // Enregistrez les modifications dans la base de données
            $em->persist($location);
            $em->flush();

             // Redirigez vers la page de détails ou une autre page
          return $this->redirectToRoute('app_location');
          }

        
   return $this->renderForm('location/createLocation.html.twig', [
    'form' => $form
   ]);

 }

 //#[Security("is_granted('ROLE_USER') and location.getUser() == user")] 
 //#[IsGranted("post-remove", "post")] 
 #[Route('/edit/{id}', name: 'location-edit')]
 public function update(Request $request, EntityManagerInterface $em, Location $location): Response
 {
     // Check if the user has permission to edit this location
 
     // Create and handle the form with the existing location data
     //dans votre LocationController
     $form = $this->createForm("App\\Form\\" . $location->getClassName() . "Type", $location);  
     $form->handleRequest($request);
 
     if ($form->isSubmitted() && $form->isValid()) {
         // Update the 'updatedAt' property
     
      
         $em->flush();
 
         return $this->redirectToRoute('app_location');
     }
 
     return $this->render('location/editLocation.html.twig', [
         'form' => $form->createView(),
     ]);
 }



 #[Route('/remove/{id}', name: 'location-remove')]
 public function delete(Location $location, Request $request, EntityManagerInterface $em): Response
 {
    //dd($location);
     $em->remove($location);
     $em->flush();

     return $this->redirectToRoute('app_location');


}




}
