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
            ["event" => "Renaissance Tour", "hall" => "Accor Arena Bercy"],
            ["event" => "Renaissance Tour", "hall" => "Accor Arena Bercy"],
            ["event" => "Renaissance Tour", "hall" => "Accor Arena Bercy"],

            ["event" => "Champagne & Roses Tour", "hall" => "Accor Arena Bercy"],
            ["event" => "Champagne & Roses Tour", "hall" => "Le Zénith de Paris"],
            ["event" => "Champagne & Roses Tour", "hall" => "Le Zénith de Paris"],

            ["event" => "Past, Present, Future Tour", "hall" => "Olympia"],
            ["event" => "Past, Present, Future Tour", "hall" => "Olympia"],

            ["event" => "Exclusive Tour", "hall" => "Le Zénith de Paris"],
            ["event" => "Exclusive Tour", "hall" => "Le Zénith de Paris"],

            ["event" => "Ronisia", "hall" => "Le Zénith de Paris"],

            ["event" => "Divinely Uninspired to a Hellish Extent Tour", "hall" => "Accor Arena Bercy"],

            ["event" => "The Mathematics Tour", "hall" => "Accor Arena Bercy"],
            ["event" => "The Mathematics Tour", "hall" => "Le Zénith de Paris"],
            ["event" => "The Mathematics Tour", "hall" => "Olympia"],

            ["event" => "Anti World Tour", "hall" => "Accor Arena Bercy"],
            ["event" => "Anti World Tour", "hall" => "Le Zénith de Paris"],

            ["event" => "Sam Smith unique concert", "hall" => "La Maroquinerie"],

            ["event" => "Jp Cooper concert", "hall" => "La Maroquinerie"],
        ];

        foreach ($data as $i => $entry) {
            $event = $this->getReference($entry["event"], Event::class );
            $hall = $this->getReference($entry["hall"], Hall::class);

            $session = new Session();
            $session->setEvent($event);
            $session->setHall($hall);

            // Date dynamique : aujourd'hui + $i jours à 20h
            $date = (new \DateTime())->modify('+' . ($i + 1) . ' days')->setTime(20, 0, 0);
            $session->setDateTime($date);

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