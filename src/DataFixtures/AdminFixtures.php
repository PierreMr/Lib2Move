<?php

namespace App\DataFixtures;

 
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AdminFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $admins = [
            ['email' => 'admin.pierre@gmail.com', 'password' => '123456', 'lastname' => 'Admin', 'firstname' => 'Pierre'],
            ['email' => 'admin.julien@hotmail.fr', 'password' => '123456', 'lastname' => 'Admin', 'firstname' => 'Julien']
        ];


        foreach ($admins as $key => $admin) {
            $newAdmin = new User();
            $newAdmin->setEmail($admin['email']);
            $newAdmin->setPassword(
                $this->passwordEncoder->encodePassword(
                    $newAdmin,
                    $admin['password']
                )
            );
            $newAdmin->setLastname($admin['lastname']);
            $newAdmin->setFirstname($admin['firstname']);
            $newAdmin->setAddress($faker->streetAddress);
            $newAdmin->setBirthday($faker->dateTimeThisCentury($max = 'now', $timezone = null));
            $newAdmin->setDriversLicence($faker->postcode);
            $newAdmin->setRoles(['ROLE_ADMIN']);
            
            $manager->persist($newAdmin);

            $this->addReference(User::class.'_admin'.$key, $newAdmin);
        }
        
        $manager->flush();
    }
}