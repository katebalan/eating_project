<?php

namespace EatingBundle\Entity;

use EatingBundle\Entity;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testAdd()
    {
        $user = new User();

	$user->setFirstName("lalala");
	$FirstName = $user->getFirstName();
	$this->assertEquals("lalala", $FirstName);

	$user->setSecondName("lalalala");
	$SecondName = $user->getSecondName();     
	$this->assertEquals("lalalala", $SecondName);

	$user->setPassword("123456");
	$Password = $user->getPassword();     
	$this->assertEquals("123456", $Password);

	$user->setAge(20);
	$Age = $user->getAge();     
	$this->assertEquals(20, $Age);

	$user->setGender("123456");
	$Gender = $user->getGender();     
	$this->assertEquals("123456", $Gender);

	$user->setPhone("123456");
	$Phone = $user->getPhone();     
	$this->assertEquals("123456", $Phone);
	
	$user->setEmail("123456");
	//$Email = $user->getEmail();     
	//$this->assertEquals("123456", $Email);

	$user->setWeight(111);
	$Weight = $user->getWeight();     
	$this->assertEquals(111, $Weight);

	$user->setHeight(111);
	$Height= $user->getHeight();     
	$this->assertEquals(111, $Height);

	$user->setEnergyExchange(111);
	$EnergyExchange= $user->getEnergyExchange();     
	$this->assertEquals(111, $EnergyExchange);

	$user->setDailyKkal(111);
	$DailyKkal= $user->getDailyKkal();     
	$this->assertEquals(111, $DailyKkal);

	$user->setDailyProteins(111);
	$DailyProteins= $user->getDailyProteins();     
	$this->assertEquals(111, $DailyProteins);

	$user->setDailyFats(123);
	$DailyFats= $user->getDailyFats();     
	$this->assertEquals(123, $DailyFats);

	$user->setDailyCarbohydrates(123);
	$DailyCarbohydrates= $user->getDailyCarbohydrates();     
	$this->assertEquals(123, $DailyCarbohydrates);

	$user->setCurrentKkal(123);
	$CurrentKkal= $user->getCurrentKkal();     
	$this->assertEquals(123, $CurrentKkal);

	$user->setCurrentProteins(123);
	$CurrentProteins= $user->getCurrentProteins();     
	$this->assertEquals(123, $CurrentProteins);

	$user->setCurrentFats(123);
	$CurrentFats= $user->getCurrentFats();     
	$this->assertEquals(123, $CurrentFats);

	$user->setCurrentCarbohydrates(123);
	$CurrentCarbohydrates= $user->getCurrentCarbohydrates();     
	$this->assertEquals(123, $CurrentCarbohydrates);

    }
}
