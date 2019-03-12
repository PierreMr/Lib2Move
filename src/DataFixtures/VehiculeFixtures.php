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
        $vehicules = [
            [
                [
                    'brand' => 'Audi',
                    'serie' => 'A4',
                ],
                [
                    'brand' => 'Audi',
                    'serie' => 'A6',
                ],
                [
                    'brand' => 'Audi',
                    'serie' => 'Q5',
                ],
                [
                    'brand' => 'Audi',
                    'serie' => 'R8',
                ],
                [
                    'brand' => 'Mercedes-Benz',
                    'serie' => 'Classe A',
                ],
                [
                    'brand' => 'Mercedes-Benz',
                    'serie' => 'Classe G',
                ],
                [
                    'brand' => 'Mercedes-Benz',
                    'serie' => 'Classe G',
                ],
                [
                    'brand' => 'Mercedes-Benz',
                    'serie' => 'Classe G',
                ],
                [
                    'brand' => 'Volkswagen',
                    'serie' => 'Polo',
                ],
                [
                    'brand' => 'Volkswagen',
                    'serie' => 'Passat',
                ],
            ],
            [
                [
                    'brand' => 'Vespa',
                    'serie' => '98',
                ],
                [
                    'brand' => 'Vespa',
                    'serie' => '125',
                ],
                [
                    'brand' => 'Vespa',
                    'serie' => 'Sprint',
                ],
                [
                    'brand' => 'Vespa',
                    'serie' => 'Granturismo',
                ],
                [
                    'brand' => 'Peugeot',
                    'serie' => 'Metropolis Allure',
                ],
                [
                    'brand' => 'Peugeot',
                    'serie' => 'Belville Allure',
                ],
                [
                    'brand' => 'Peugeot',
                    'serie' => 'Citystar',
                ],
                [
                    'brand' => 'Peugeot',
                    'serie' => 'Kisbee',
                ],
                [
                    'brand' => 'Suzuki',
                    'serie' => 'Katana',
                ],
                [
                    'brand' => 'Suzuki',
                    'serie' => 'Street Magic',
                ],
            ],
            [
                [
                    'brand' => 'Razor',
                    'serie' => 'E300',
                ],
                [
                    'brand' => 'Razor',
                    'serie' => 'E90',
                ],
                [
                    'brand' => 'Micro',
                    'serie' => 'Merlin',
                ],
                [
                    'brand' => 'Micro',
                    'serie' => 'Condor',
                ],
                [
                    'brand' => 'Micro',
                    'serie' => 'Falcon',
                ],
                [
                    'brand' => 'Oxelo',
                    'serie' => 'Freestyle',
                ],
                [
                    'brand' => 'Oxelo',
                    'serie' => 'Town',
                ],
            ],
        ];

        $villes = [
            [
                'latMin' => 48.83370272345498,
                'latMax' => 48.88475067793349,
                'lonMin' => 2.2900743330078512,
                'lonMax' => 2.3855180585937887,
            ],
            [
                'latMin' => 45.72594660979239,
                'latMax' => 45.78117048537809,
                'lonMin' => 4.786006150976618,
                'lonMax' => 4.882517507126295,
            ],
        ];

        $images = ['transport', 'transport', 'transport'];

        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $newVehicule = new Vehicule();

            $type = rand(0, 2);
            $brand = rand(0, count($vehicules[$type])-1);

            $ville = rand(0, 1);

            $newVehicule->setBrand($vehicules[$type][$brand]['brand']);
            $newVehicule->setSerie($vehicules[$type][$brand]['serie']);
            $newVehicule->setSerialNumber($faker->regexify('[A-Za-z0-9]{9}'));
            $newVehicule->setColor($faker->safeColorName);
            $newVehicule->setLicensePlate($faker->regexify('[A-Z]{2}[0-9]{3}[A-Z]{2}'));
            $newVehicule->setKilometers($faker->numberBetween($min = 1000, $max = 200000));
            $newVehicule->setPurchaseDate($faker->dateTimeThisDecade($max = 'now', $timezone = null));
            $newVehicule->setPurchasePrice($faker->numberBetween($min = 5000, $max = 70000));
            $newVehicule->setStatus('Disponible');
            $newVehicule->setLat($faker->latitude($min = $villes[$ville]['latMin'], $max = $villes[$ville]['latMax']));
            $newVehicule->setLon($faker->longitude($min = $villes[$ville]['lonMin'], $max = $villes[$ville]['lonMax']));
            $newVehicule->setImage($faker->imageUrl($width = 640, $height = 480, $images[$type]));

            $newVehicule->setType($this->getReference(TypeVehicule::class.'_'.$type));
            $newVehicule->setVille($this->getReference(Ville::class.'_'.$ville));
            
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
