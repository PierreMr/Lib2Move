<?php

namespace App\DataFixtures;

 
use App\Entity\Location;
use App\Entity\User;
use App\Entity\Vehicule;
use App\Entity\Contrat;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

use App\DataFixtures\UserFixtures;
use App\DataFixtures\VehiculeFixtures;
use App\DataFixtures\ContratFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
 
class LocationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');


        for ($i = 0; $i < 20; $i++) {
            $newLocation = new Location();
        
            $vehicule = rand(0, 19);
            $type = $this->getReference(Vehicule::class.'_'.$vehicule)->getType()->getId() - 1;
            $contrat = [$type, rand(0, 2)];

            $date = $faker->dateTimeThisDecade($max = 'now', $timezone = 'Europe/Paris');
            $start = new \DateTimeImmutable($date->format('Y-m-d H:i:s'));
            $newLocation->setStart($start);

            $time = $this->getReference(Contrat::class.'_'.$contrat[0].'_'.$contrat[1])->getMaxTime();
            $hours = $time->format('H');
            $minutes = $time->format('i');
            $intervalString = 'PT'.$hours.'H'.$minutes.'M';
            $newLocation->setEnd($date->add(new \DateInterval($intervalString)));

            // $newLocation->setKilometers(rand(10, 100));
            // $newLocation->setTime(new \DateTime('00:'.rand(10, 50)));
            $newLocation->setStatus('En cours');
            $newLocation->setCreatedAt(new \DateTime('now'));

            $newLocation->setUser($this->getReference(User::class.'_'.rand(0, 7)));
            $newLocation->setVehicule($this->getReference(Vehicule::class.'_'.$vehicule));
            $newLocation->setContrat($this->getReference(Contrat::class.'_'.$contrat[0].'_'.$contrat[1]));
            
            $manager->persist($newLocation);

            $this->addReference(Location::class.'_'.$i, $newLocation);
        }

        $manager->flush(); 
    }

    public function getDependencies()
    {
        return [UserFixtures::class, VehiculeFixtures::class, ContratFixtures::class];
    }
}
