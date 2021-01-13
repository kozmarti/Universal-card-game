<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUsername('vlad');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'password'
        ));
        $manager->persist($user);

        $user2 = new User();
        $user2->setUsername('mathias');
        $user2->setPassword($this->passwordEncoder->encodePassword(
            $user2,
            'password'
        ));
        $manager->persist($user2);

        $user3 = new User();
        $user3->setUsername('marta');
        $user3->setPassword($this->passwordEncoder->encodePassword(
            $user3,
            'password'
        ));
        $manager->persist($user3);



        $manager->flush();
    }
}
