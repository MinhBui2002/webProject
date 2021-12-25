<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 0;$i <= 30; $i++){
            $product = new Product;
            $product->setProductName("Product $i");
            $product->setCategory(null);
            $product->setProductPrice(1000+$i);
            $product->setProductImage("cover.jpg");
            $product->setProductQuantity(50+$i);
            $product->setProductDescription("Description $i");
            $manager->persist($product);
        }

        $manager->flush();
    }
}
