<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    // public const CATEGORY_REFERENCES = [

    //     "R&B",
    //     "Pop",
    //     "Reggae",
    //     "Rap",
    //     "Urban pop",
    //     "Rock"

    // ];

    public function load(ObjectManager $manager): void
    {

        $categories = [

            "R&B",
            "Pop",
            "Reggae",
            "Rap",
            "Urban pop",
            "Rock"
    
        ];

        foreach($categories as $one_category){

            $category = new Category();
            $category->setName($one_category);

            $manager->persist($category);

            $this->addReference($one_category, $category);
        }

        $manager->flush();
    }

}