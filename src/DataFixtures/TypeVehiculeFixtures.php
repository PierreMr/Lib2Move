<?php

namespace App\DataFixtures;

 
use App\Entity\TypeVehicule;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class TypeVehiculeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

    	$typeVehicules = ['Voiture', 'Scooter', 'Trottinette'];

    	for ($i = 0; $i < count($typeVehicules); $i++) {
            $newTypeVehicule = new TypeVehicule();
            $newTypeVehicule->setName($typeVehicules[$i]);
            
            $manager->persist($newTypeVehicule);
        	
        	$this->addReference(TypeVehicule::class.'_'.$i, $newTypeVehicule);
        }

        $manager->flush();
    }
}