<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
// use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $faker = Faker\Factory::create('fr_FR');

        for ($i=0; $i < 200; $i++) {

            $product = new Product();
            $product->setName($this->faker->name());
            $product->setPrice($this->faker->randomDigit());
            $product->setBody($this->faker->realText());

            $manager->persist($product);
        }

        $manager->flush();
    }
}
