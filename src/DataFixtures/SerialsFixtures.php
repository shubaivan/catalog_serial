<?php

namespace App\DataFixtures;

use App\Entity\Serial;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SerialsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $product = new Serial();
            $product->setName('serial'.$i);
            $product->setShortDescription('description'.$i);
            $manager->persist($product);
        }

        $manager->flush();
    }
}
