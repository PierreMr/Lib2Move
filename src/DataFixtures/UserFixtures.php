<?php

namespace App\DataFixtures;

 
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $users = [
            ['email' => 'mauerpierre@gmail.com', 'password' => '123456', 'lastname' => 'Mauer', 'firstname' => 'Pierre'],
            ['email' => 'julien.laville@hotmail.fr', 'password' => '123456', 'lastname' => 'Laville', 'firstname' => 'Julien']
        ];


        foreach ($users as $key => $user) {
            $newUser = new User();
            $newUser->setEmail($user['email']);
            $newUser->setPassword(
                $this->passwordEncoder->encodePassword(
                    $newUser,
                    $user['password']
                )
            );
            $newUser->setLastname($user['lastname']);
            $newUser->setFirstname($user['firstname']);
            $newUser->setAddress($faker->streetAddress);
            $newUser->setBirthday($faker->dateTimeThisCentury($max = 'now', $timezone = null));
            $newUser->setDriversLicence($faker->postcode);
            
            $manager->persist($newUser);

            $this->addReference(User::class.'_'.$key, $newUser);
        }
 
        for ($i = 2; $i < 7; $i++) {
            $newUser = new User();
            $newUser->setEmail($faker->email);
            $newUser->setPassword(
                $this->passwordEncoder->encodePassword(
                    $newUser,
                    '123456'
                )
            );
            $newUser->setFirstname($faker->firstName);
            $newUser->setLastname($faker->lastName);
            $newUser->setAddress($faker->streetAddress);
            $newUser->setBirthday($faker->dateTimeThisCentury($max = 'now', $timezone = null));
            $newUser->setDriversLicence($faker->postcode);
            
            $manager->persist($newUser);

            $this->addReference(User::class.'_'.$i, $newUser);
        }
        
        $manager->flush();
    }
}