<?php

namespace App\Repository;

use App\Entity\Dumpster;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Dumpster|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dumpster|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dumpster[]    findAll()
 * @method Dumpster[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DumpsterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dumpster::class);
    }


    public function findDumpsterByCoos($latitude, $longitude){
        $query = $this->createQueryBuilder('a')
            ->where("Geography(ST_Point(:val, :val2)) = a.coordinates")
            ->setParameter(':val', $latitude)
            ->setParameter(':val2', $longitude);
        return $query->getQuery()->getResult();
    }


    public function nextTo($pts1, $pts2)
    {
        $rayon = 2000;
        $query = $this->createQueryBuilder('b')
            ->where("ST_DWithin(b.coordinates, Geography(ST_SetSRID(ST_Point(:val,:val2),4326)), :val3) = true")
            ->setParameter(':val', $pts1)
            ->setParameter(':val2', $pts2)
            ->setParameter(':val3',$rayon)

        ;
        return $query->getQuery()->getResult();

    }

    // /**
    //  * @return Dumpster[] Returns an array of Dumpster objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Dumpster
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
