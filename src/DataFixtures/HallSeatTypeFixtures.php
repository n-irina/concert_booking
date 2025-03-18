<?php

namespace App\DataFixtures;

use App\Entity\Hall;
use App\Entity\HallSeatType;
use App\Entity\SeatType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class HallSeatTypeFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {

        $data = [
            
            ["hall" => "La Maroquinerie", "seat_type" => "Floor", "capacity" => 500],

            ["hall" => "Accor Arena Bercy", "seat_type" => "VIP", "capacity" => 1000],
            ["hall" => "Accor Arena Bercy", "seat_type" => "Gold square", "capacity" => 2000],
            ["hall" => "Accor Arena Bercy", "seat_type" => "Front row", "capacity" => 5000],
            ["hall" => "Accor Arena Bercy", "seat_type" => "Rear row", "capacity" => 5000],
            ["hall" => "Accor Arena Bercy", "seat_type" => "Floor", "capacity" => 8000],
            
            ["hall" => "Olympia", "seat_type" => "VIP", "capacity" => 200],
            ["hall" => "Olympia", "seat_type" => "Gold square", "capacity" => 500],
            ["hall" => "Olympia", "seat_type" => "Front row", "capacity" => 1300],

            ["hall" => "Le Zénith de Paris", "seat_type" => "Gold square", "capacity" => 1500],
            ["hall" => "Le Zénith de Paris", "seat_type" => "Rear row", "capacity" => 3000],
            ["hall" => "Le Zénith de Paris", "seat_type" => "Floor", "capacity" => 1800],
        ];

        foreach ($data as $entry) {
            $hall = $this->getReference($entry["hall"], Hall::class );
            $seatType = $this->getReference($entry["seat_type"], SeatType::class);

            $hallSeatType = new HallSeatType();
            $hallSeatType->setHall($hall);
            $hallSeatType->setSeatType($seatType);
            $hallSeatType->setCapacity($entry["capacity"]);

            $manager->persist($hallSeatType);

        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            HallFixtures::class,
            SeatTypeFixtures::class,
        ];
    }
}