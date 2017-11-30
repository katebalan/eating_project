<?php

namespace EatingBundle\Entity;


use PHPUnit\Framework\TestCase;

class ConsumptionTest extends TestCase
{
    public function testAdd(){
        $consumption = new Consumption();

        $set_user = new User();
        $set_user->setAge(15);
        $consumption->setUser($set_user);
        $get_user = $consumption->getUser();
        $this->assertEquals($set_user, $get_user);

        $set_product = new Products();
        $set_product->setName('lalala');
        $consumption->setProduct($set_product);
        $get_product = $consumption->getProduct();
        $this->assertEquals($set_product, $get_product);

        $consumption->setHowMuch(250);
        $how_much = $consumption->getHowMuch();
        $this->assertEquals(250, $how_much);

        $consumption->setMealsOfTheDay('SupperDinner15');
        $meals_of_the_day = $consumption->getMealsOfTheDay();
        $this->assertEquals('SupperDinner15', $meals_of_the_day);

        $consumption->setCreatedAt(22);
        $CreatedAt= $consumption->getCreatedAt();
        $this->assertEquals(22, $CreatedAt);
    }
}
