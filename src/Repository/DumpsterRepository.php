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
