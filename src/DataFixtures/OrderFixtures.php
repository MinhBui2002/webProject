<?php

namespace App\DataFixtures;

use App\Entity\Order;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrderFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for($i = 0;$i <= 30; $i++){
            $order = new Order;
            $order->setOrderDate(new \DateTime());
            $order->setUser(null);
            $manager->persist($order);
        }

        $manager->flush();
    }
}
