<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public const CATEGORY_REFERENCES = [

        "R&B",
        "Pop",
        "Reggae",
        "Rap",
        "Urban pop",
        "Rock"

    ];

    public function load(ObjectManager $manager): void
    {

        for($i=0; $i<5; $i++){

            $category = new Category();
            $category->setName(self::CATEGORY_REFERENCES[$i]);

            $manager->persist($category);

            $this->addReference(self::CATEGORY_REFERENCES[$i], $category);
        }

        $manager->flush();
    }

}