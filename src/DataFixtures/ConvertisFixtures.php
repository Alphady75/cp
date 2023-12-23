<?php

namespace App\DataFixtures;

use App\Entity\Convertis;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ConvertisFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($nbconvertis = 1; $nbconvertis <= 100; $nbconvertis++) {

            $converti = new Convertis();

            if ($nbconvertis == 1) {

                $converti->setInstagram('alphady');
                $converti->setNumero('+242 06 965 2292');
            } else {
                $converti->setInstagram($faker->firstName);
                $converti->setNumero($faker->phoneNumber);
            }

            $converti->setIp($faker->ipv4);
            $converti->setListeAttente($faker->numberBetween(0, 1));
            $converti->setCountRec($faker->numberBetween(0, 30));
            $manager->persist($converti);

            // Enregistre l'utilisateur dans une référence
            $this->addReference('converti_' . $nbconvertis, $converti);
        }

        $manager->flush();
    }
}
