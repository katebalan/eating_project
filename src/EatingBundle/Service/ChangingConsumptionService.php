<?php
/**
 * Created by PhpStorm.
 * User: katya
 * Date: 08.12.17
 * Time: 12:10
 */

namespace EatingBundle\Service;


use EatingBundle\Entity\Consumption;

class ChangingConsumptionService
{
    public function MakeOtherList(Consumption $consumption, $date)
    {
        if ( !empty($consumption)) {
            $day_consumption[$date]['breakfast'] = array();
            $day_consumption[$date]['dinner'] = array();
            $day_consumption[$date]['supper'] = array();
        }

        for ($j = 0; $j < count($consumption); $j++) {
            if ($consumption[$j]->getMealsOfTheDay() == 'Breakfast') {
                array_push($day_consumption[$date]['breakfast'], $consumption[$j]);
            }
            if ($consumption[$j]->getMealsOfTheDay() == 'Dinner') {
                array_push($day_consumption[$date]['dinner'], $consumption[$j]);
            }
            if ($consumption[$j]->getMealsOfTheDay() == 'Supper') {
                array_push($day_consumption[$date]['supper'], $consumption[$j]);
            }
        }

        return $day_consumption;

    }

}