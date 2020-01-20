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
class UserRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

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


/* ===============
   Updates Users
================ */
    /**
     * @param Users $users
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    public function updateUser(Users $users, $data)
    {
        empty($data['mail']) ? true : $users->setMail($data['mail']);
        empty($data['password']) ? true : $users->setPassword($data['password']);
        empty($data['role']) ? true : $users->setRoles($data['role']);
        empty($data['token']) ? true : $users->setToken($data['token']);
        $users->setUpdatedAt(new \DateTime("now"));
        $this->manager->flush();
    }

/* ===============
   Deletes Users
================ */
    /**
     * @param Users $users
     * @return mixed
     */
    public function deleteUser(Users $users)
    {
        $this->manager->remove($users);
        $this->manager->flush();
    }


}
