<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Genus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures2 implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $objects = Fixtures::load(__DIR__ . '/fixtures.yml',
            $manager,
            [
                'providers' => [$this]
            ]);
    }

    public function product_name()
    {
        $genera = [
            'Supper',
            'Dinner',
            'Breakfast',
        ];
        $number = rand(0, 100);
        $key = array_rand($genera);

        return $genera[$key].$number;
    }

    public function activities()
    {
        $genera = [
            'Walking',
            'Running',
            'Gym',
            'Yoga',
        ];

        $key = array_rand($genera);

        return $genera[$key];
    }
}
