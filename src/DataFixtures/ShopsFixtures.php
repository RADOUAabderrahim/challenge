<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Shops;

class ShopsFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        for ($i=0; $i<100; $i++){
            $shop = new Shops();
            $shop->setName($faker->company);
            $shop->setDistance($faker->numberBetween(1,10000));
            $manager->persist($shop);
        }
            $manager->flush();
    }
}
