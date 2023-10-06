<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class SearchController extends AbstractController
{
    //parametre search en option car const url a un seul parametre
    #[Route('/api_city/{search?}', name: 'api_city')]
    public function search(string $search, LocationRepository $locationRepo, EntityManagerInterface $em): Response
    {
        
        $conn = $em->getConnection();
        $sql = 'SELECT ville_departement, ville_nom_simple, ville_latitude_deg, ville_longitude_deg 
        FROM spec_villes_france_free
        WHERE ville_nom_simple like :param';
        $request = $conn->prepare($sql);
        $resultSet  = $request->executeQuery(['param' => '%'.$search.'%']);
        $results = $resultSet->fetchAllAssociative();

        return $this->json($results);

   }

  /* #[Route('/searchhousing', name: 'search_housing')]
   public function searchHousing( Request $request, LocationRepository $locationRepo): Response
   {
    
    $location = $request->get('where');
    $capacity = $request->get('people');
    $beginning = $request->get('begin');
    $ending = $request->get('end');

    $locations = $locationRepo->findLocations($capacity);
    //dd ($locations);

    return $this->render('home/index.html.twig', [
        'locations' => $locations
     
  ]);

   }*/
   #[Route('/searchhousing', name: 'search_housing')]
   public function searchHousing( Request $request, LocationRepository $locationRepo): Response
   {
    
    $city = $request->get('where');
    $capacity = $request->get('people');
    $beginning = $request->get('begin');
    $ending = $request->get('end');
    
   

    $locations = $locationRepo->findLocations($city, $capacity);
    //dd ($locations);

    return $this->render('home/index.html.twig', [
        'locations' => $locations,
        
  ]);
 }
   



   

 }
        

