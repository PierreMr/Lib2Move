<?php

namespace App\DataFixtures;

 
use App\Entity\Vehicule;
use App\Entity\TypeVehicule;
use App\Entity\Ville;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

use App\DataFixtures\TypeVehiculeFixtures;
use App\DataFixtures\VilleFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
 
class VehiculeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $newVehicule = new Vehicule();

            $newVehicule->setBrand($faker->company);
            $newVehicule->setSerie($faker->tld);
            $newVehicule->setSerialNumber($faker->ean8);
            $newVehicule->setColor($faker->safeColorName);
            $newVehicule->setLicensePlate($faker->isbn13);
            $newVehicule->setKilometers($faker->ean8);
            $newVehicule->setPurchaseDate($faker->dateTimeThisCentury($max = 'now', $timezone = null));
            $newVehicule->setStatus('Disponible');

            $newVehicule->setType($this->getReference(TypeVehicule::class.'_'.rand(0, 2)));
            $newVehicule->setVille($this->getReference(Ville::class.'_'.rand(0, 1)));
            
            $manager->persist($newVehicule);

            $this->addReference(Vehicule::class.'_'.$i, $newVehicule);
        }

        $manager->flush(); 
    }

    public function getDependencies()
    {
        return [TypeVehiculeFixtures::class, VilleFixtures::class];
    }
}
