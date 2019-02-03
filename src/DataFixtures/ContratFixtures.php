<?php

namespace App\DataFixtures;

 
use App\Entity\Contrat;
use App\Entity\TypeVehicule;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

use App\DataFixtures\TypeVehiculeFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ContratFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $contrats = ['Voiture', 'Scooter', 'Trottinette'];
    	$types = ['A', 'B', 'C'];

        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $newContrat = new Contrat();
                $newContrat->setName($contrats[$i].' '.$types[$j]);
                $newContrat->setMaxKm(rand(10, 50));
                $newContrat->setMaxTime(new \DateTime('00:'.rand(10, 50)));
                $newContrat->setPrice(20.5);
                $newContrat->setKmPenalty(0.5);
                $newContrat->setTimePenalty(0.5);
                $newContrat->setType($this->getReference(TypeVehicule::class.'_'.$i));

                $manager->persist($newContrat);

                $this->addReference(Contrat::class.'_'.$i.'_'.$j, $newContrat);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [TypeVehiculeFixtures::class];
    }
}