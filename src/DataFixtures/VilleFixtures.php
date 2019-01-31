<?php

namespace App\DataFixtures;

 
use App\Entity\Ville;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class VilleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
    	
    	$villes = ['Paris', 'Lyon'];

    	for ($i = 0; $i < count($villes); $i++) {
            $newVille = new Ville();
            $newVille->setName($villes[$i]);
            
            $manager->persist($newVille);
        	
        	$this->addReference(Ville::class.'_'.$i, $newVille);
        }

        $manager->flush();
    }
}