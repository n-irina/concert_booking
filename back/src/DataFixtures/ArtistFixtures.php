<?php

namespace App\DataFixtures;

use App\Entity\Artist;
use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ArtistFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager): void
    {

        $artists = [
            [
                "nickname" => "Beyoncé",
                "description" => "Beyoncé Giselle Knowles-Carter (born September 4, 1981) is an American singer-songwriter, actress and businesswoman. She has had a significant impact on the music industry and is known for her vocal ability, musical versatility, live performances, and culturally important works.",
                "image_path" => "beyonce.jpg",
                "category" => [
                    "Pop",
                    "R&B"
                ]
            ],
            [
                "nickname" => "Ne-Yo",
                "description" => "Shaffer Chimere Smith (born October 18, 1979), known professionally as Ne-Yo, is an American singer and songwriter. Regarded as a leading figure of 2000s R&B music, he is the recipient of numerous accolades, including three Grammy Awards.",
                "image_path" => "neyo.jpg",
                "category" => [
                    "R&B",
                    "Pop"
                ]
            ],
            [
                "nickname" => "Usher",
                "description" => "Usher Raymond IV (born October 14, 1978) is an American singer, songwriter, dancer, and actor. Often referred to as the King of R&B, he is recognized as an influential figure in contemporary R&B and pop music",
                "image_path" => "usher.jpg",
                "category" => [
                    "R&B",
                    "Pop"
                ]
            ],
            [
                "nickname" => "Chris Brown",
                "description" => "Christopher Maurice Brown (born May 5, 1989) is an American singer, songwriter, dancer, and actor. A pop and hip-hop-influenced R&B musician who works in a variety of genres, he has been called the 'King of R&B' by some of his contemporaries",
                "image_path" => "chris_brown.jpg",
                "category" => "R&B"
            ],
            [
                "nickname" => "Mario",
                "description" => "Mario Dewar Barrett (born August 27, 1986), known mononymously as Mario, is an American R&B singer. Born and raised in Baltimore, Maryland, he signed a record deal with J Records at the age of 14 and released his self-titled debut studio album (2002) to commercial success.",
                "image_path" => "mario.jpg",
                "category" => "R&B"
            ],
            [
                "nickname" => "Ronisia",
                "description" => "Ronizia Mendes Borges1 was born on November 13, 1999 in Tarrafal, Cape Verde, and grew up in Grigny, in the Essonne region.",
                "image_path" => "ronisia.jpg",
                "category" => "Urban pop"
            ],
            [
                "nickname" => "Lewis Capaldi",
                "description" => "Lewis Marc Capaldi (born 7 October 1996) is a Scottish singer-songwriter and musician. In March 2019, his single 'Someone You Loved' (2018) topped the UK Singles Chart where it remained for seven weeks, and in November 2019, it reached number one on the US Billboard Hot 100",
                "image_path" => "lewis_capaldi.jpg",
                "category" => "Pop"
            ],
            [
                "nickname" => "Ed Sheeran",
                "description" => "Edward Christopher Sheeran (born 17 February 1991) is an English singer-songwriter. Born in Halifax, West Yorkshire, and raised in Framlingham, Suffolk, he began writing songs around the age of eleven.",
                "image_path" => "ed_sheeran.jpg",
                "category" => "Pop"
            ],
            [
                "nickname" => "Rihanna",
                "description" => "Robyn Rihanna Fenty (born February 20, 1988) is a Barbadian singer, businesswoman and actress. She is the best-selling female recording artist of the 21st century by Guinness World Records and the highest-certified female digital single artist by RIAA.",
                "image_path" => "rihanna.jpg",
                "category" => [
                    "R&B",
                    "Pop"
                ]
            ],
            [
                "nickname" => "Sam Smith",
                "description" => "Samuel Frederick Smith (born 19 May 1992) is an English singer and songwriter. In 2012, they rose to prominence when they featured on Disclosure's breakthrough single 'Latch', which peaked at number eleven on the UK Singles Chart.",
                "image_path" => "sam_smith.jpg",
                "category" => "Pop"
            ],
            [
                "nickname" => "Jp Cooper",
                "description" => "John Paul Cooper (born 1 November 1983) is an English singer and songwriter. He is best known for featuring on the single 'Perfect Strangers' by DJ and producer Jonas Blue.",
                "image_path" => "jp_cooper.jpg",
                "category" => "Pop"
            ],
            [
                "nickname" => "Bob Marley",
                "description" => "Robert Nesta Marley (6 February 1945 - 11 May 1981) was a Jamaican singer, songwriter, and guitarist. Considered one of the pioneers of reggae, he fused elements of reggae, ska and rocksteady and was renowned for his distinctive vocal and songwriting style",
                "image_path" => "bob_marley.jpg",
                "category" => "Reggae"
            ],
        ];

        foreach($artists as $one_artist){

            $artist = new Artist();
            $artist->setNickname($one_artist["nickname"]);
            $artist->setDescription($one_artist["description"]);
            $artist->setImagePath($one_artist["image_path"]);

            if(is_array($one_artist["category"])){
                foreach($one_artist["category"] as $category){
                    $category_reference = $this->getReference($category, Category::class);
                    $artist->addCategory($category_reference);
                }               
            }else{
                $category_reference = $this->getReference($one_artist["category"], Category::class);
                $artist->addCategory($category_reference);
            }

            $manager->persist($artist);

            $this->addReference($one_artist["nickname"], $artist);

        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
        ];
    }

}