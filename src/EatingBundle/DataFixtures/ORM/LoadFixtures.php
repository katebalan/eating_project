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
    private $activity_image_key = 0;
    private $product_image_key = 0;

    private $activity = [
        'walking',
        'running',
        'gym',
        'yoga',
    ];

    private $produts = [
        'bacon',
        'cheese',
        'eggs',
        'granola',
        'omelet',
        'sausage',
        'slice of bread',
        'slice of toast',
        'hot chocolate',
        'milk',
        'tea',
        'sugar',
        'water',
        'yogurt',
        'chicken',
        'pizza',
        'caesar\'s salad',
        'chef salad',
        'broccoli',
        'apple',
        'banana',
        'cherry',
    ];

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
        return ucfirst($this->produts[$this->product_key++]);
    }

    /**
     * @return mixed
     */
    public function activity_name()
    {
        return ucfirst($this->activity[$this->activity_key++]);
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
        return str_replace(' ', '_', $this->produts[$this->product_image_key++]) . ".jpg";
    }

    public function activity_image()
    {
        return $this->activity[$this->activity_image_key++] . ".jpg";
    }
}
