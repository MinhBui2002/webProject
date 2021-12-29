<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for($i = 0;$i <= 30; $i++){
            $user = new User;
            $user->setEmail("$i@gmail.com");
            $user->setPassword("123456");
            $user->setRoles('ROLE_CUSTOMER ');
            $manager->persist($user);
        }

        $manager->flush();
    }
}
