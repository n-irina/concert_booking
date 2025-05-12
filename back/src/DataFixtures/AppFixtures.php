<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            ArtistFixtures::class,
            HallFixtures::class,
            SeatTypeFixtures::class,
            EventFixtures::class,
            SessionFixtures::class,
            SessionSeatTypeFixtures::class,
            UserFixtures::class,
        ];
    }
}
