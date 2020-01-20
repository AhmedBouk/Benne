<?php

namespace App\Repository;

use App\Entity\Dumpster;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Dumpster|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dumpster|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dumpster[]    findAll()
 * @method Dumpster[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DumpsterRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Dumpster::class);
        $this->manager = $manager;
    }

    /* ==============
       Adds Dumpster
    ================= */
    public function addDumpster($name, $type, $latitude, $longitude, $idCity, $status){
        $dumpster = new Dumpster();

        empty($name) ? true : $dumpster->setName($name);
        empty($type) ? true : $dumpster->setType($type);
        empty($latitude) && empty($longitude) ? true : $dumpster->setCoordinates('POINT('. $latitude . ' ' . $longitude .')');
        empty($id_city) ? true : $dumpster->setIdCity($idCity);
        empty($status) ? true : $dumpster->setStatus($status);
        $dumpster->setIsEnabled(FALSE);

        $this->manager->persist($dumpster);
        $this->manager->flush();
    }

/* =============================
   Updates Dumpster in Database
============================= */
    /**
     * @param Dumpster $dumpster
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function updateDumpster(Dumpster $dumpster, $data)
    {
        empty($data['name']) ? true : $dumpster->setName($data['name']);
        empty($data['type']) ? true : $dumpster->setType($data['type']);
        empty($data['coordinates']) ? true : $dumpster->setCoordinates('POINT('. $data['coordinates'] .')');
        empty($data['status']) ? true : $dumpster->setStatus($data['status']);
        $dumpster->setUpdatedAt(new \DateTime("now"));
        $this->manager->flush();
    }

/* =============================
   Deletes Dumpster in Database
============================= */
    /**
     * @param Dumpster $dumpster
     * @return mixed
     */
    public function deleteDumpster(Dumpster $dumpster)
    {
        $this->manager->remove($dumpster);
        $this->manager->flush();
    }

/* ===================================================
   finds dumpster with given coordinates in database
=================================================== */
    /**
     * @param $latitude
     * @param $longitude
     * @return mixed
     */
    public function findDumpsterByCoos($latitude, $longitude)
    {
        $query = $this->createQueryBuilder('a')
            ->where("Geography(ST_Point(:val, :val2)) = a.coordinates")
            ->setParameter(':val', $latitude)
            ->setParameter(':val2', $longitude);
        return $query->getQuery()->getResult();
    }

/* ============================================
   finds dumpster with given type in database
============================================ */
    /**
     * @param $type
     * @return array
     */
    public function findDumpsterByType($type) : array
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT d
            FROM App\Entity\Dumpster d
            WHERE d.type = :type'
        )->setParameter('type', $type);
        return $query->getArrayResult();
    }

/* ====================================================================
   finds dumpsters within 2000m next to given coordinates in database
==================================================================== */
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
