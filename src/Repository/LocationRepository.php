<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Location>
 *
 * @method Location|null find($id, $lockMode = null, $lockVersion = null)
 * @method Location|null findOneBy(array $criteria, array $orderBy = null)
 * @method Location[]    findAll()
 * @method Location[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

     /**
     * @return Location[] Returns an array of Bed objects
     */
   /* public function findLocations($capacity): array
    {
        return $this->createQueryBuilder('l')
            ->join('l.rooms', 'r') 
            ->join('r.roomDetails', 'rd')  
            ->join('rd.bed', 'rdb')
            ->groupBy('l.id')
            ->having('SUM(rd.quantity * rdb.capacity) >= :capacity')
            ->setParameter('capacity', $capacity)
            ->getQuery()
            ->getResult()
        ;
    }
*/


   /**
     * @return Location[] Returns an array of Bed objects
     */
    public function findLocations($city, $capacity): array
    {
        $conn=$this->getEntityManager()->getConnection();
        $sql = 'SELECT ville_departement, ville_nom_simple, ville_latitude_deg, ville_longitude_deg 
        FROM spec_villes_france_free
        WHERE ville_nom_simple like :param';
        $request = $conn->prepare($sql);
        $resultSet  = $request->executeQuery(['param' => '%'.$city.'%']);
        $results = $resultSet->fetchAssociative();
        return $this->createQueryBuilder('l')
            ->addSelect("ACOS(SIN(PI()*l.latitude/180.0)*SIN(PI()*:lat2/180.0)+COS(PI()*l.latitude/180.0)*COS(PI()*:lat2/180.0)*COS(PI()*:lon2/180.0-PI()*l.longitude/180.0))*6371 AS dist")
            ->join('l.rooms', 'r') 
            ->join('r.roomDetails', 'rd')  
            ->join('rd.bed', 'rdb')
            ->orderBy("dist")
            ->groupBy('l.id')
            ->andhaving('SUM(rd.quantity * rdb.capacity) >= :capacity')
            ->setParameter('lat2', $results["ville_latitude_deg"])
            ->setParameter('lon2',$results["ville_longitude_deg"])
            ->setParameter('capacity', $capacity)
            ->getQuery()
            ->getResult()
        ;
    }










  
//    /**
//     * @return Location[] Returns an array of Location objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Location
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
