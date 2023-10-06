<?php

namespace App\Controller;

use App\Entity\Room;
use App\Form\RoomType;
use App\Entity\Location;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoomController extends AbstractController
{
    #[IsGranted("ROLE_USER")]
        #[Route('/createroom/{location}', name: 'create_room')]
        public function createRoom(Location $location, Request $request, EntityManagerInterface $em): Response
        {
           $room = new Room();
   
               // Assurez-vous que l'utilisateur connecté est associé au room
    

         $form = $this->createForm(RoomType::class, $room);

         $form->handleRequest($request);
              



              if ($form->isSubmitted() && $form->isValid()) { 
                $room->setLocation($location);
             // Enregistrez les modifications dans la base de données
                $em->persist($room);
                $em->flush();

                 // Redirigez vers la page de détails ou une autre page
              return $this->redirectToRoute('app_room');
              }

    
       return $this->render('room/createroom.html.twig', [
        'form' => $form
       ]);

     }


        //#[Security("is_granted('ROLE_USER') and room.getAuthor() == user")]
    #[IsGranted("room-edit", "room")] 
    #[Route('/edit/{id}', name: 'room-edit')]
    public function update(Request $request, EntityManagerInterface $em, Room $room): Response
    {
        // Check if the user has permission to edit this room
    
        // Create and handle the form with the existing room data
        $form = $this->createForm(RoomType::class, $room);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
          
            $em->flush();
    
            return $this->redirectToRoute('room_index');
        }
    
        return $this->render('room/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
      //  #[Security("is_granted('ROLE_USER') and room.getAuthor() == user")] 
     #[IsGranted("room-remove", "room")]     
     #[Route('/remove/{id}', name: 'room-remove')]
     public function delete( Room $room, Request $request, EntityManagerInterface $em): Response
     {
        //dd($room);
         $em->remove($room);
         $em->flush();
 
         return $this->redirectToRoute('room_index');


 }

      
    #[Route('/rooms', name: 'app_room')]
    public function index(RoomRepository $roomRepository)
    {
        
        $rooms = $roomRepository->findAll();

        // Retournez les données au format JSON
        return $this->render('room/listroom.html.twig', [
            'rooms' => $rooms
        ]);
    }





}
