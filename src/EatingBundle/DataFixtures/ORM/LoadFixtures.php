<?php

namespace EatingBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadFixtures implements FixtureInterface
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

    public function activity_name()
    {
        $activity = [
            'Walking',
            'Running',
            'Gym',
            'Yoga',
        ];
        $number = rand(0, 100);
        $key = array_rand($activity);

        return $activity[$key].$number;
    }

    public function user_phone()
    {
        $phone = '+38099';
        for($i = 0; $i < 7; $i++){
            $number = rand(0, 9);
            $phone = $phone.$number;
        }

        return $phone;
    }

    public function meals_of_the_day()
    {
        $meals = [
            'Breakfast',
            'Dinner',
            'Supper'
        ];

        $key = array_rand($meals);

        return $meals[$key];
    }
}
