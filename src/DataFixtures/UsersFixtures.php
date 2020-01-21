<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        $admin_user = new Users();
        $admin_user->setMail('admin@test.com');
        $admin_user->setPassword($this->passwordEncoder->encodePassword(
            $admin_user,
            'admin'
        ));
        $admin_user->setRole('ROLE_SUPER_ADMIN');
        $admin_user->setIsEnabled(1);
        $admin_user->setToken('tokendesesmorts');
        $manager->persist($admin_user);

        $classic_user = new Users();
        $classic_user->setMail('user@test.com');
        $classic_user->setPassword($this->passwordEncoder->encodePassword(
            $classic_user,
            'user'
        ));
        $classic_user->setRole('ROLE_USER');
        $classic_user->setIsEnabled(1);
        $classic_user->setToken('tokendesesmorts');
        $manager->persist($classic_user);

        $manager->flush();
    }
}