<?php

namespace App\DataFixtures;

use App\Entity\SeatType;
use App\Entity\Session;
use App\Entity\SessionSeatType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SessionSeatTypeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $data = [
            // Renaissance Tour - Accor Arena Bercy
            "Renaissance Tour - Accor Arena Bercy 1" => [
                ["seat_type" => "VIP", "price" => 150.00, "available_seats" => 1000],
                ["seat_type" => "Gold square", "price" => 120.00, "available_seats" => 2000],
                ["seat_type" => "Front row", "price" => 100.00, "available_seats" => 5000],
                ["seat_type" => "Rear row", "price" => 90.00, "available_seats" => 5000],
                ["seat_type" => "Floor", "price" => 80.00, "available_seats" => 8000],
            ],
            "Renaissance Tour - Accor Arena Bercy 2" => [
                ["seat_type" => "VIP", "price" => 160.00, "available_seats" => 1000],
                ["seat_type" => "Gold square", "price" => 130.00, "available_seats" => 2000],
                ["seat_type" => "Front row", "price" => 115.00, "available_seats" => 5000],
                ["seat_type" => "Rear row", "price" => 95.00, "available_seats" => 5000],
                ["seat_type" => "Floor", "price" => 85.00, "available_seats" => 8000],
            ],
            "Renaissance Tour - Accor Arena Bercy 3" => [
                ["seat_type" => "VIP", "price" => 170.00, "available_seats" => 1000],
                ["seat_type" => "Gold square", "price" => 140.00, "available_seats" => 2000],
                ["seat_type" => "Front row", "price" => 120.00, "available_seats" => 5000],
                ["seat_type" => "Rear row", "price" => 110.00, "available_seats" => 5000],
                ["seat_type" => "Floor", "price" => 90.00, "available_seats" => 8000],
            ],
        
            // Champagne & Roses Tour - Accor
            "Champagne & Roses Tour - Accor Arena Bercy 1" => [
                ["seat_type" => "VIP", "price" => 140.00, "available_seats" => 1000],
                ["seat_type" => "Gold square", "price" => 120.00, "available_seats" => 2000],
                ["seat_type" => "Front row", "price" => 100.00, "available_seats" => 5000],
                ["seat_type" => "Rear row", "price" => 90.00, "available_seats" => 5000],
                ["seat_type" => "Floor", "price" => 75.00, "available_seats" => 8000],
            ],
            // Champagne & Roses Tour - Zénith
            "Champagne & Roses Tour - Le Zénith de Paris 1" => [
                ["seat_type" => "Gold square", "price" => 120.00, "available_seats" => 1500],
                ["seat_type" => "Rear row", "price" => 100.00, "available_seats" => 3000],
                ["seat_type" => "Floor", "price" => 80.00, "available_seats" => 1800],
            ],
            "Champagne & Roses Tour - Le Zénith de Paris 2" => [
                ["seat_type" => "Gold square", "price" => 120.00, "available_seats" => 1500],
                ["seat_type" => "Rear row", "price" => 100.00, "available_seats" => 3000],
                ["seat_type" => "Floor", "price" => 80.00, "available_seats" => 1800],
            ],
        
            // Past, Present, Future Tour - Olympia
            "Past, Present, Future Tour - Olympia 1" => [
                ["seat_type" => "VIP", "price" => 200.00, "available_seats" => 200],
                ["seat_type" => "Gold square", "price" => 160.00, "available_seats" => 500],
                ["seat_type" => "Front row", "price" => 140.00, "available_seats" => 1300],
            ],
            "Past, Present, Future Tour - Olympia 2" => [
                ["seat_type" => "VIP", "price" => 210.00, "available_seats" => 200],
                ["seat_type" => "Gold square", "price" => 170.00, "available_seats" => 500],
                ["seat_type" => "Front row", "price" => 150.00, "available_seats" => 1300],
            ],
        
            // Exclusive Tour - Le Zénith de Paris
            "Exclusive Tour - Le Zénith de Paris 1" => [
                ["seat_type" => "Gold square", "price" => 130.00, "available_seats" => 1500],
                ["seat_type" => "Rear row", "price" => 90.00, "available_seats" => 3000],
                ["seat_type" => "Floor", "price" => 70.00, "available_seats" => 1800],
            ],

            // Ronisia - Le Zénith de Paris
            "Ronisia - Le Zénith de Paris 1" => [
                ["seat_type" => "Gold square", "price" => 90.00, "available_seats" => 1500],
                ["seat_type" => "Rear row", "price" => 70.00, "available_seats" => 3000],
                ["seat_type" => "Floor", "price" => 55.00, "available_seats" => 1800],
            ],
            // Lewis Capaldi - Accor
            "Divinely Uninspired to a Hellish Extent Tour - Accor Arena Bercy 1" => [
                ["seat_type" => "VIP", "price" => 120.00, "available_seats" => 1000],
                ["seat_type" => "Gold square", "price" => 100.00, "available_seats" => 2000],
                ["seat_type" => "Front row", "price" => 80.00, "available_seats" => 5000],
                ["seat_type" => "Rear row", "price" => 70.00, "available_seats" => 5000],
                ["seat_type" => "Floor", "price" => 50.00, "available_seats" => 8000],
            ],
            // The Mathematics Tour - Accor
            "The Mathematics Tour - Accor Arena Bercy 1" => [
                ["seat_type" => "VIP", "price" => 200.00, "available_seats" => 1000],
                ["seat_type" => "Gold square", "price" => 170.00, "available_seats" => 2000],
                ["seat_type" => "Front row", "price" => 130.00, "available_seats" => 5000],
                ["seat_type" => "Rear row", "price" => 100.00, "available_seats" => 5000],
                ["seat_type" => "Floor", "price" => 90.00, "available_seats" => 8000],
            ],
            // The Mathematics Tour - Zénith
            "The Mathematics Tour - Le Zénith de Paris 1" => [
                ["seat_type" => "Gold square", "price" => 150.00, "available_seats" => 1500],
                ["seat_type" => "Rear row", "price" => 130.00, "available_seats" => 3000],
                ["seat_type" => "Floor", "price" => 100.00, "available_seats" => 1800],
            ],
            // The Mathematics Tour - Olympia
            "The Mathematics Tour - Olympia 1" => [
                ["seat_type" => "VIP", "price" => 200.00, "available_seats" => 200],
                ["seat_type" => "Gold square", "price" => 160.00, "available_seats" => 500],
                ["seat_type" => "Front row", "price" => 140.00, "available_seats" => 1300],
            ],
            // Anti World Tour - Accor
            "Anti World Tour - Accor Arena Bercy 1" => [
                ["seat_type" => "VIP", "price" => 200.00, "available_seats" => 1000],
                ["seat_type" => "Gold square", "price" => 170.00, "available_seats" => 2000],
                ["seat_type" => "Front row", "price" => 130.00, "available_seats" => 5000],
                ["seat_type" => "Rear row", "price" => 100.00, "available_seats" => 5000],
                ["seat_type" => "Floor", "price" => 90.00, "available_seats" => 8000],
            ],
            // Anti World Tour - Zénith
            "Anti World Tour - Le Zénith de Paris 1" => [
                ["seat_type" => "Gold square", "price" => 180.00, "available_seats" => 1500],
                ["seat_type" => "Rear row", "price" => 160.00, "available_seats" => 3000],
                ["seat_type" => "Floor", "price" => 120.00, "available_seats" => 1800],
            ],
            //Sam Smith unique concert - La maroquinerie
            "Sam Smith unique concert - La Maroquinerie 1" => [
                ["seat_type" => "Floor", "price" => 80.00, "available_seats" => 500],
            ],
            //Jp Cooper Concert - La maroquinerie
            "Jp Cooper concert - La Maroquinerie 1" => [
                ["seat_type" => "Floor", "price" => 50.00, "available_seats" => 500],
            ]
        ];
        

        foreach ($data as $sessionKey => $seatTypes) {
            $session = $this->getReference($sessionKey, Session::class);
        
            foreach ($seatTypes as $entry) {
                $seatType = $this->getReference($entry["seat_type"], SeatType::class);
        
                $sessionSeatType = new SessionSeatType();
                $sessionSeatType->setSession($session);
                $sessionSeatType->setSeatType($seatType);
                $sessionSeatType->setPrice($entry["price"]);
                $sessionSeatType->setAvailableSeats($entry["available_seats"]);
        
                $manager->persist($sessionSeatType);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SeatTypeFixtures::class,
            SessionFixtures::class,
        ];
    }
}