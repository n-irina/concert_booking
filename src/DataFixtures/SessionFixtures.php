<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Hall;
use App\Entity\Session;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SessionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $data = [
            
            ["event" => "Renaissance Tour", "hall" => "Accor Arena Bercy", "date_time" => "2026-12-01 20:00:00"],
            ["event" => "Renaissance Tour", "hall" => "Accor Arena Bercy", "date_time" => "2026-12-02 20:00:00"],
            ["event" => "Renaissance Tour", "hall" => "Accor Arena Bercy", "date_time" => "2026-12-03 20:00:00"],

            ["event" => "Champagne & Roses Tour", "hall" => "Accor Arena Bercy", "date_time" => "2026-01-01 20:30:00"],
            ["event" => "Champagne & Roses Tour", "hall" => "Le Zénith de Paris", "date_time" => "2026-01-02 20:00:00"],
            ["event" => "Champagne & Roses Tour", "hall" => "Le Zénith de Paris", "date_time" => "2026-01-03 19:30:00"],

            ["event" => "Past, Present, Future Tour", "hall" => "Olympia", "date_time" => "2025-09-10 19:30:00"],
            ["event" => "Past, Present, Future Tour", "hall" => "Olympia", "date_time" => "2025-09-11 20:30:00"],
            
            ["event" => "Exclusive Tour", "hall" => "Le Zénith de Paris", "date_time" => "2025-08-20 20:00:00"],
            ["event" => "Exclusive Tour", "hall" => "Le Zénith de Paris", "date_time" => "2025-08-21 20:00:00"],

            ["event" => "Ronisia", "hall" => "Le Zénith de Paris", "date_time" => "2024-05-12 20:00:00"],

            ["event" => "Divinely Uninspired to a Hellish Extent Tour", "hall" => "Accor Arena Bercy", "date_time" => "2025-02-26 20:00:00"],

            ["event" => "The Mathematics Tour", "hall" => "Accor Arena Bercy", "date_time" => "2025-07-13 20:00:00"],
            ["event" => "The Mathematics Tour", "hall" => "Le Zénith de Paris", "date_time" => "2025-07-14 20:00:00"],
            ["event" => "The Mathematics Tour", "hall" => "Olympia", "date_time" => "2025-07-15 20:00:00"],

            ["event" => "Anti World Tour", "hall" => "Accor Arena Bercy", "date_time" => "2024-06-28 20:30:00"],
            ["event" => "Anti World Tour", "hall" => "Le Zénith de Paris", "date_time" => "2024-06-29 20:00:00"],

            ["event" => "Sam Smith unique concert", "hall" => "La Maroquinerie", "date_time" => "2025-10-08 19:30:00"],

            ["event" => "Jp Cooper concert", "hall" => "La Maroquinerie", "date_time" => "2025-11-19 19:30:00"],
        ];

        foreach ($data as $entry) {

            $event = $this->getReference($entry["event"], Event::class );
            $hall = $this->getReference($entry["hall"], Hall::class);

            $session = new Session();
            $session->setEvent($event);
            $session->setHall($hall);
            $session->setDateTime(new \DateTime($entry["date_time"]));

            $manager->persist($session);

            $key = $entry["event"] . " - " . $entry["hall"];

            if (!isset($session_counters[$key])) {
                $session_counters[$key] = 1;
            } else {
                $session_counters[$key]++;
            }

            $reference_key = $key . " " . $session_counters[$key];

            $this->addReference($reference_key, $session);

        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            HallFixtures::class,
            EventFixtures::class,
        ];
    }
}