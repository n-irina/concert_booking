<?php

namespace App\DataFixtures;

use App\Entity\SeatType;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture 
{

    public function load(ObjectManager $manager): void
    {

        $roles = ['ROLE_ADMIN', 'ROLE_USER'];

        //creating users
        for($i=1; $i<11; $i++){
            $user = new User();
            $user->setEmail('user'.$i. '@demo.com');
            $user->setPlainPassword('@Demo2025'.$i);
            $user->setRoles([$roles[1]]);
            $manager->persist($user);
        }
        
        //creating admin
        for($i=1; $i<11; $i++){
            $admin = new User();
            $admin->setEmail('admin'.$i. '@demo.com');
            $admin->setPlainPassword('@Demo2025'.$i);
            $admin->setRoles([$roles[0]]);
            $manager->persist($admin);
        }

        $manager->flush();
    }

}