<?php

namespace App\Repository;

use App\Entity\UserDumpster;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserDumpster|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserDumpster|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserDumpster[]    findAll()
 * @method UserDumpster[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserDumpsterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserDumpster::class);
    }

    // /**
    //  * @return UserDumpster[] Returns an array of UserDumpster objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserDumpster
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
