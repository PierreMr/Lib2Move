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
        $kms = [
            [
                10,
                30,
                50
            ],
            [
                5,
                10,
                20
            ],
            [
                1,
                5,
                10
            ],
        ];
        $times = [
            [
                '01:00',
                '04:00',
                '08:00',
            ],
            [
                '00:15',
                '00:30',
                '01:00',
            ],
            [
                '00:10',
                '00:30',
                '00:45',
            ],
        ];
        $prices = [
            [
                15,
                30,
                40,
            ],
            [
                5,
                10,
                20,
            ],
            [
                3,
                10,
                18,
            ],
        ];

        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $newContrat = new Contrat();
                $newContrat->setName($contrats[$i].' '.$types[$j]);
                $newContrat->setMaxKm($kms[$i][$j]);
                $newContrat->setMaxTime(new \DateTime($times[$i][$j]));
                $newContrat->setPrice($prices[$i][$j]);
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