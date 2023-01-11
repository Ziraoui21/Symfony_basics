<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setUsername('Ziraoui22');
        $password = $this->passwordEncoder->hashPassword($user,'12344321');
        $user->setPassword($password);
        $user->setRoles(['Role_Admin']);
        $manager->persist($user);

        $manager->flush();
    }
}
