<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(BookingRepository $locationRepo): Response
    {
        $locations = $locationRepo->findAll();
        $user = $this->getUser();
    return $this->render('home/index.html.twig', [
        'user' => $user,
        'locations' => $locations,
       
    ]);
    }
    #[Route('/createLocationChoose', name: 'app_formChooselocation')]
    public function chooseLocationForm(): Response
    {
        return $this->render('booking/chooseLocation.html.twig');
    }

   
    #[Route('/createLocation/{typeLocation}', name: 'app_createLocation')]
    public function create( Request $request, EntityManagerInterface $em, string $typeLocation): Response
    {

       $booking = new ("App\\Entity\\".$typeLocation)();

     /*  if (class_exists('App\\Entity\\' . $type) && get_parent_class('App\\Entity\\' . $type) == "App\\Entity\\Booking") {*/
 

       // Assurez-vous que l'utilisateur connecté est associé au booking
       $booking->setUser($this->getUser());
       //dd($booking);

   

     $form = $this->createForm("App\\Form\\".$typeLocation."Type", $booking);



     $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) { 
            


         // Enregistrez les modifications dans la base de données
            $em->persist($booking);
            $em->flush();

             // Redirigez vers la page de détails ou une autre page
          return $this->redirectToRoute('app_location');
          }

        
   return $this->renderForm('booking/createLocation.html.twig', [
    'form' => $form
   ]);

 }
  
}