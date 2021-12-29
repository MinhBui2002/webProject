<?php

namespace App\DataFixtures;

use App\Entity\UserDetail;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserDetailFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for($i = 0; $i<30;$i++){
            $userDetail = new UserDetail();
            $userDetail->setUserAddress("Address 1");
            $userDetail->setUserName("Name $i");
            $userDetail->setUserPhonenum("098765432$i");
            $manager->persist($userDetail);
        }
        $manager->flush();
    }
}
