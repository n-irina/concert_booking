<?php

namespace App\DataFixtures;

use App\Entity\Hall;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HallFixtures extends Fixture 
{

    public const HALL_REFERENCES = [

        "La Cigale",
        "La Maroquinerie",
        "Olympia",
        "La Gaîté Lyrique",
        "Philharmonie de Paris",
        "Accor Arena Bercy",
        "Le Zénith de Paris"

    ];

    public function load(ObjectManager $manager): void
    {

        $halls = [
            [
                "name" => "La Cigale",
                "address" => "120 boulevard de Rochechouart 75018 Paris",
                "capacity" => 1400,
                "descritpion" => "With its horseshoe shape, its moulded balconies topped with red borders and this theatrical dome, the Cigale is one of the most beautiful and renowned venues in the capital."
            ],
            [
                "name" => "La Maroquinerie",
                "address" => "23 rue Boyer 75020 Paris",
                "capacity" => 500,
                "descritpion" => "Is La Maroquinerie one of the best concert halls in Paris? The question deserves to be asked as the hall hidden on the heights of Ménilmontant has assets to make a belote player cry."
            ],
            [
                "name" => "Olympia",
                "address" => "28 boulevard des Capucines 75009 Paris",
                "capacity" => 2000,
                "descritpion" => "The hall, which has a capacity of 2,000 seats between the pit and the mezzanine, hosts concerts of all genres as well as shows for the general public all year round."
            ],
            [
                "name" => "La Gaîté Lyrique",
                "address" => "3 bis rue Papin 75003 Paris",
                "capacity" => 850,
                "descritpion" => "After ten thousand lives and ten years of work, the Théâtre de la Gaîté was transformed in 2011 into the epicentre of Parisian cultural life 2.0."
            ],
            [
                "name" => "Philharmonie de Paris",
                "address" => "221 avenue Jean Jaurès 75019 Paris",
                "capacity" => 2400,
                "descritpion" => "The Philharmonie, with its large 2,400-seat hall, offers a sumptuous and abundant program led by the resident musicians of the Orchestre de Paris."
            ],
            [
                "name" => "Accor Arena Bercy",
                "address" => "8 boulevard de Bercy 75012 Paris",
                "capacity" => 20000,
                "descritpion" => "A pyramid of grass planted at the western end of the park, on the banks of the Seine, the spot hosts international gymnastics competitions as well as boxing matches, but above all a plethora of French and international artists."
            ],
            [
                "name" => "Le Zénith de Paris",
                "address" => "211 avenue Jean Jaurès 75019 Paris",
                "capacity" => 6300,
                "descritpion" => " Located in the Parc de la Villette in the 19th arrondissement and completed in 1983, the building contains 6,300 seats, making it the third largest stadium in the city after the Parc des Princes and Bercy."
            ],
        ];

        foreach($halls as $index => $one_hall){

            $hall = new Hall();
            $hall->setName($one_hall["name"]);
            $hall->setAddress($one_hall["address"]);
            $hall->setCapacity($one_hall["capacity"]);
            $hall->setDescription($one_hall["descritpion"]);

            $manager->persist($hall);

            $this->addReference(self::HALL_REFERENCES[$index], $hall);

        }
        
        $manager->flush();
    }

}