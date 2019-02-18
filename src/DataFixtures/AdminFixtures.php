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

        $superadmins = [
            ['email' => 'admin@gmail.com', 'password' => '123456', 'lastname' => 'Super', 'firstname' => 'Admin'],
        ];

        $admins = [
            ['email' => 'admin.pierre@gmail.com', 'password' => '123456', 'lastname' => 'Admin', 'firstname' => 'Pierre'],
            ['email' => 'admin.julien@hotmail.fr', 'password' => '123456', 'lastname' => 'Admin', 'firstname' => 'Julien'],
            ['email' => 'admin.jeancy@gmail.com', 'password' => '123456', 'lastname' => 'Admin', 'firstname' => 'Jeancy'],
        ];

        foreach ($superadmins as $key => $superadmin) {
            $newAdmin = new User();
            $newAdmin->setEmail($superadmin['email']);
            $newAdmin->setPassword(
                $this->passwordEncoder->encodePassword(
                    $newAdmin,
                    $superadmin['password']
                )
            );
            $newAdmin->setLastname($superadmin['lastname']);
            $newAdmin->setFirstname($superadmin['firstname']);
            $newAdmin->setAddress($faker->streetAddress);
            $newAdmin->setBirthday($faker->dateTimeThisCentury($max = 'now', $timezone = null));
            $newAdmin->setDriversLicence($faker->postcode);
            $newAdmin->setImage($faker->imageUrl());
            $newAdmin->setRoles(['ROLE_SUPERADMIN']);
            
            $manager->persist($newAdmin);

            $this->addReference(User::class.'_admin'.$key, $newAdmin);
        }

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
            $newAdmin->setImage($faker->imageUrl());
            $newAdmin->setRoles(['ROLE_ADMIN']);
            
            $manager->persist($newAdmin);

            $this->addReference(User::class.'_admin'.($key + count($superadmins)), $newAdmin);
        }
        
        $manager->flush();
    }
}