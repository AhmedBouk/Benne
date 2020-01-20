<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Users::class);
        $this->manager = $manager;
    }


    /* =============
       Adds Users
    ============== */
    public function addUser($mail, $password, $role, $token)
    {
        $user = new Users();

        empty($mail) ? true : $user->setmail($mail);
        empty($password) ? true : $user->setPassword($password);
        empty($role) ? true : $user->setRoles($role);
        $user->setIsEnabled(FALSE);
        empty($token) ? true : $user->setToken($token);
        $user->setCreatedAt(new \DateTime("now"));

        $this->manager->persist($user);
        $this->manager->flush();
    }


    /* =============
       Updates Users
    ============== */

    /* =============
       Deletes Users
    ============== */

    /* ================
       Lists all users
    ================ */


}
