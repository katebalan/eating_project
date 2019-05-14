<?php

namespace EatingBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use EatingBundle\Entity\Products;
use EatingBundle\Entity\User;

/**
 * Class CountService
 * @package EatingBundle\Service
 */
class CountService
{
    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    /**
     * @var array
     */
    private $properties = [
        'Kkal',
        'Proteins',
        'Fats',
        'Carbohydrates'

    ];

    /**
     * CountService constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param User $user
     * @return User
     */
    public function countDailyValues(User $user)
    {
        $weight = $user->getWeight();
        $energy_exchange = $user->getEnergyExchange();
        $daily_kkal = 0;

        if($user->getAge() <= 30 && $user->getGender() == false) {
            $daily_kkal = (0.0621 * $weight + 2.0357) * 240 * $energy_exchange;
        }
        elseif($user->getAge() > 30 && $user->getAge() <= 60 && $user->getGender() == false) {
            $daily_kkal = (0.0342 * $weight + 3.5377) * 240 * $energy_exchange;
        }
        elseif($user->getAge() > 60 && $user->getGender() == false) {
            $daily_kkal = (0.0377 * $weight + 2.7545) * 240 * $energy_exchange;
        }
        elseif($user->getAge() <= 30 && $user->getGender() == true) {
            $daily_kkal = (0.0630 * $weight + 2.8957) * 240 * $energy_exchange;
        }
        elseif($user->getAge() > 30 && $user->getGender() == true) {
            $daily_kkal = (0.0491 * $weight + 2.4587) * 240 * $energy_exchange;
        }
        else {
            $user->setDailyKkal(0);
        }

        $user->setDailyKkal(round($daily_kkal));
        $daily_parts = round($daily_kkal / 6, 2, PHP_ROUND_HALF_UP);

        $daily_fats = round($daily_parts / 9, 2, PHP_ROUND_HALF_UP);
        $daily_proteins = round($daily_parts / 4, 2, PHP_ROUND_HALF_UP);
        $daily_carbohydrates = $daily_parts;

        $user->setDailyFats($daily_fats);
        $user->setDailyProteins($daily_proteins);
        $user->setDailyCarbohydrates($daily_carbohydrates);

        return $user;
    }

    /**
     * @param User $user
     * @param $how_much
     * @param Products $product
     * @return User
     */
    public function countCurrentValues(User $user, $how_much, Products $product)
    {
        foreach ($this->properties as $property) {
            $user->{'setCurrent' . $property}(
                $user->{'getCurrent' . $property}() + $how_much * $product->{'get' . $property . 'Per100gr'}() / 100
            );
        }

        return $user;
    }

    /**
     * @param User $user
     * @return array
     */
    public function consumptionToArray(User $user, $count_days = 1)
    {
        $day_consumption = array();

        for ($i = 0; $i < $count_days; $i++) {
            $date = new \DateTime();
            $date->modify('-'.$i.' days');

            $consumption = $this->em->getRepository('EatingBundle:Consumption')
                ->findByDateAndUserActive($user, $date);
            $str_date = $date->format('Y-m-d');

            if ( !empty($consumption)) {
                $day_consumption[$str_date]['breakfast'] = array();
                $day_consumption[$str_date]['dinner'] = array();
                $day_consumption[$str_date]['supper'] = array();
            }

            for ($j = 0; $j < count($consumption); $j++) {
                if ($consumption[$j]->getMealsOfTheDay() == 'Breakfast') {
                    array_push($day_consumption[$str_date]['breakfast'], $consumption[$j]);
                }
                if ($consumption[$j]->getMealsOfTheDay() == 'Dinner') {
                    array_push($day_consumption[$str_date]['dinner'], $consumption[$j]);
                }
                if ($consumption[$j]->getMealsOfTheDay() == 'Supper') {
                    array_push($day_consumption[$str_date]['supper'], $consumption[$j]);
                }
            }
        }

        return $day_consumption;
    }
}
