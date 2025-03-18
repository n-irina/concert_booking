<?php

namespace App\DataFixtures;

use App\Entity\SeatType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SeatTypeFixtures extends Fixture 
{

    public const SEAT_TYPE_REFERENCES = [

        "VIP",
        "Gold square",
        "Front row",
        "Rear row",
        "Floor"

    ];

    public function load(ObjectManager $manager): void
    {

        $seat_types = [
            [
                "name" => "VIP",
                "description" => "VIP box with unlimited drinks and appetizers"
            ],
            [
                "name" => "Gold square",
                "description" => "Best seats for the best view"
            ],
            [
                "name" => "Front row",
                "description" => "Seating around the stage"
            ],
            [
                "name" => "Rear row",
                "description" => "Row furthest from the stage"
            ],
            [
                "name" => "Floor",
                "description" => "Standing placement"
            ],
        ];

        foreach($seat_types as $index => $one_seat_type){

            $seat_type = new SeatType();
            $seat_type->setName($one_seat_type["name"]);
            $seat_type->setDescription($one_seat_type["description"]);

            $manager->persist($seat_type);

            $this->addReference(self::SEAT_TYPE_REFERENCES[$index], $seat_type);

        }

        $manager->flush();
    }

}