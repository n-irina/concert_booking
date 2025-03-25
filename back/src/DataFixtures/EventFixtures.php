<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {

        $events = [
            [
                "artist" => "Beyoncé",
                "name" => "Renaissance Tour",
                "description" => "The Renaissance World Tour was the ninth concert tour by American singer and songwriter Beyoncé. Her highest-grossing tour to date, it was staged in support of her seventh studio album, Renaissance (2022).",
                "picture_path" => "concert_beyonce.jpg",
            ],
            [
                "artist" => [
                    "Ne-Yo",
                    "Mario"
                ],
                "name" => "Champagne & Roses Tour",
                "description" => "The artist known for his hits such as 'Closer', 'Miss Independent' and 'Sexy Love', also participated in the writing of 'Let Me Love You' by Mario who will be his guest on the 'Champagne & Roses Tour'",
                "picture_path" => "concert_neyo_mario.jpg"
            ],
            [
                "artist" => "Usher",
                "name" => "Past, Present, Future Tour",
                "description" => "Known for his hits 'yeah!', 'Love in This Club' or his great classic from 20 years ago 'My Boo' featuring Alicia Keys, Usher promises to take us on a journey between his past, his present but also his future",
                "picture_path" => "concert_usher.jpg"
            ],
            [
                "artist" => "Chris Brown",
                "name" => "Exclusive Tour",
                "description" => "After releasing his 'exclusive' album, Chris Brown went on tour to promote it",
                "picture_path" => "concert_cb.jpg"
            ],
            [
                "artist" => "Ronisia",
                "name" => "Ronisia",
                "description" => "After releasing her eponymous album, Ronisia offers us an exclusive concert",
                "picture_path" => "concert_ronisia.jpg"
            ],
            [
                "artist" => "Lewis Capaldi",
                "name" => "Divinely Uninspired to a Hellish Extent Tour",
                "description" => "Join Lewis Capaldi for a European tour",
                "picture_path" => "concert_lewis.jpg"
            ],
            [
                "artist" => "Ed Sheeran",
                "name" => "The Mathematics Tour",
                "description" => "The +-=÷× Tour (pronounced The Mathematics Tour) is the ongoing fourth concert tour by English singer-songwriter Ed Sheeran.",
                "picture_path" => "concert_ed.jpg"
            ],
            [
                "artist" => "Rihanna",
                "name" => "Anti World Tour",
                "description" => "The Anti World Tour was the seventh concert tour by Barbadian singer Rihanna, in support of her eighth studio album, Anti (2016).",
                "picture_path" => "concert_rihanna.jpg"
            ],
            [
                "artist" => "Sam Smith",
                "name" => "Sam Smith unique concert",
                "description" => "Meet Sam Smith for a unique concert",
                "picture_path" => "concert_sam.jpg"
            ],
            [
                "artist" => "Jp Cooper",
                "name" => "Jp Cooper concert",
                "description" => "An enchanting voice, on the border between soul and RnB tinged with folk, the English John Paul Cooper wants to give concerts in intimate places, as close as possible to his fans.",
                "picture_path" => "concert_jp.jpg"
            ],

        ];

        foreach($events as $one_event){

            $event = new Event();
            if (is_array($one_event["artist"])) {
                foreach ($one_event["artist"] as $one_artist) {
                    $artist = $this->getReference($one_artist, Artist::class);
                    $event->addArtist($artist);
                }
            } else {
                $artist = $this->getReference($one_event["artist"], Artist::class);
                $event->addArtist($artist);
            }
            $event->setName($one_event["name"]);
            $event->setDescription($one_event["description"]);
            if(isset($one_event["picture_path"])){
                $event->setPicturePath($one_event["picture_path"]);
            }

            $manager->persist($event);

            $this->addReference($one_event["name"], $event);
            
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ArtistFixtures::class,
        ];
    }
}