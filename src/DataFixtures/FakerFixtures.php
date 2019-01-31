<?php

namespace App\DataFixtures;

 
use App\Entity\User;
// use App\Entity\Ville;
use App\Entity\Vehicule;
use App\Entity\TypeVehicule;

// use App\Repository\TypeVehiculeRepository;
// use App\Repository\VilleRepository;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

/* User - Type Vehicule */
class FakerFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');
 
        // on créé 10 users
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail($faker->email);
            $user->setPassword('123456');
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setAddress($faker->streetAddress);
            $user->setBirthday($faker->dateTimeThisCentury($max = 'now', $timezone = null));
            $user->setDriversLicence($faker->postcode);
            
            $manager->persist($user);
        }

        $typeVehiculeName = ['Voiture', 'Scooter', 'Trottinette'];
        $villeName = ['Paris', 'Lyon'];

        for ($i = 0; $i < count($typeVehiculeName); $i++) {

            $typeVehicule = new TypeVehicule();
            $typeVehicule->setName($typeVehiculeName[$i]);
    
            $manager->persist($typeVehicule);
        }
            $manager->flush();
    }
}

        /*
        // on crée 12 villes
        for ($i = 0; $i < 20; $i++) {

            $ville = new ville();
            $ville->setName('Paris '.$i.'éme');
            $ville->setZIP('750'.$i.'');
            
            $manager->persist($ville);
        }
        */