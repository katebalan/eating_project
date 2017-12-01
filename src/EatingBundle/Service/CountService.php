<?php

namespace EatingBundle\Service;


use EatingBundle\Entity\Consumption;
use EatingBundle\Entity\Products;
use EatingBundle\Entity\User;

class CountService
{
    public function CountDailyValues(User $user)
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

    public function CountCurrentValues(User $user, $how_much, Products $product)
    {
        $current_kkal = $user->getCurrentKkal() + $how_much * $product->getKkalPer100gr() / 100;
        $current_proteins = $user->getCurrentProteins() + $how_much * $product->getProteinsPer100gr() / 100;
        $current_fats = $user->getCurrentFats() + $how_much * $product->getFatsPer100gr() / 100;
        $current_carb = $user->getCurrentCarbohydrates() + $how_much * $product->getCarbohydratesPer100gr() / 100;

        $user->setCurrentKkal($current_kkal);
        $user->setCurrentProteins($current_proteins);
        $user->setCurrentFats($current_fats);
        $user->setCurrentCarbohydrates($current_carb);

        return $user;
    }
}
