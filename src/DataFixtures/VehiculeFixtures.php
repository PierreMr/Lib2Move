<?php

namespace App\DataFixtures;

 
use App\Entity\User;
//  use App\Entity\Ville;
use App\Entity\Vehicule;
use App\Entity\TypeVehicule;

use App\Repository\TypeVehiculeRepository;
use App\Repository\VilleRepository;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

 
class VehiculeFixtures extends Fixture
{

    private $typeVehiculeRepository;
    private $villeRepository;

    public function __construct(TypeVehiculeRepository $typeVehiculeRepository, VilleRepository $villeRepository) 
    {
        $this->typeVehiculeRepository = $typeVehiculeRepository;
        $this->villeRepository = $villeRepository;

    }

    public function load(ObjectManager $manager)
    {
        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

         for ($i = 0; $i < 20; $i++) {

            $typeVehiculeName = ['Voiture', 'Scooter', 'Trottinette'];
    
            $typeVehicule = $this->typeVehiculeRepository->findBy(["id" => rand(1, count($typeVehiculeName))]);
            // $ville = $this->villeRepository->find(rand(1, count($villeName)));
            
            $vehicule = new Vehicule();

            $vehicule->setType($typeVehicule);
            //$vehicule->setVille($ville);

            $vehicule->setBrand($faker->company);
            $vehicule->setSerie($faker->tld);
            $vehicule->setSerialNumber($faker->ean8);
            $vehicule->setColor($faker->safeColorName);
            $vehicule->setLicensePlate($faker->isbn13);
            $vehicule->setKilometers($faker->ean8);
            $vehicule->setPurchaseDate($faker->dateTimeThisCentury($max = 'now', $timezone = null));
            $vehicule->setStatus('dispo');
            
            
            $manager->persist($vehicule);
        }
 
    }
}
