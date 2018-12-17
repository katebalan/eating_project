<?php

namespace EatingBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

/**
 * Class LoadFixtures
 * @package EatingBundle\DataFixtures\ORM
 */
class LoadFixtures implements FixtureInterface
{
    /**
     * @var int
     */
    private $product_key = 0;

    /**
     * @var int
     */
    private $activity_key = 0;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $objects = Fixtures::load(__DIR__ . '/fixtures.yml',
            $manager,
            [
                'providers' => [$this]
            ]);
    }

    /**
     * @return mixed
     */
    public function product_name()
    {
        $produts = [
            'Bacon',
            'Cheese',
            'Eggs',
            'Granola',
            'Omelet',
            'Sausage',
            'Slice of bread',
            'Slice of toast',
            'Hot chocolate',
            'Milk',
            'Tea',
            'Sugar',
            'Water',
            'Yogurt',
            'Chicken',
            'Pizza',
            'Caesar\'s salad',
            'Chef salad',
            'Broccoli',
            'Apple',
            'Banana',
            'Cherry',
        ];

        return $produts[$this->product_key++];
    }

    /**
     * @return mixed
     */
    public function activity_name()
    {
        $activity = [
            'Walking',
            'Running',
            'Gym',
            'Yoga',
        ];

        return $activity[$this->activity_key++];
    }

    /**
     * @return string
     */
    public function user_phone()
    {
        $phone = '+38099';
        for($i = 0; $i < 7; $i++){
            $number = rand(0, 9);
            $phone = $phone.$number;
        }

        return $phone;
    }

    /**
     * @return mixed
     */
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

    public function product_image()
    {
        $images = [
            'food1.jpg',
            'food2.jpg',
            'food3.jpg',
        ];

        $key = array_rand($images);

        return $images[$key];
    }
}
