<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Location;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    #[Route('/booking', name: 'app_booking')]
    public function index(BookingRepository $bookingRepository): Response
    {
        $bookings = $bookingRepository->findAll();
        
        
        return $this->render('booking/index.html.twig', [
            'bookings' => $bookings,          
        ]);
    }

    #[Route('/createBooking/{location}', name: 'app_createBooking')]
    public function create( Location $location, Request $request, EntityManagerInterface $em): Response
    {

       $booking = new Booking();

     /*  if (class_exists('App\\Entity\\' . $type) && get_parent_class('App\\Entity\\' . $type) == "App\\Entity\\Booking") {*/

       $form = $this->createForm(BookingType::class, $booking);



     $form->handleRequest($request);

          if ($form->isSubmitted() && $form->isValid()) { 
            $booking->setLocation();


         // Enregistrez les modifications dans la base de données
            $em->persist($booking);
            $em->flush();

             // Redirigez vers la page de détails ou une autre page
          return $this->redirectToRoute('app_booking');
          }

        
   return $this->renderForm('booking/createBooking.html.twig', [
    'form' => $form
   ]);

 }


}