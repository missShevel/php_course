<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Cat;

class CatFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $cat = new Cat();
            $cat->setName($faker->firstName);
            $cat->setAge($faker->numberBetween(1, 15));
            $cat->setBreed($faker->word);
            $cat->setColor($faker->safeColorName);
            $cat->setCharacter($faker->text(50));

            $manager->persist($cat);
        }

        $manager->flush();
    }
}
