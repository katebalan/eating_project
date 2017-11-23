<?php

namespace EatingBundle\Entity;

use EatingBundle\Entity;
use PHPUnit\Framework\TestCase;

class ActivityTest extends TestCase
{
    public function testAdd()
    {
        $activity = new Activity();

	$activity->setName("lalala");
	$Name = $activity->getName();
	$this->assertEquals("lalala", $Name);

	$activity->setKkalPer5minutes(11);
	$KkalPer5minutes = $activity->getKkalPer5minutes();
	$this->assertEquals(11, $KkalPer5minutes);

	$activity->setProteinsPer5minutes(22);
	$ProteinsPer5minutes = $activity->getProteinsPer5minutes();
	$this->assertEquals(22, $ProteinsPer5minutes);

	$activity->setFatsPer5minutes(22);
	$FatsPer5minutes = $activity->getFatsPer5minutes();
	$this->assertEquals(22, $FatsPer5minutes);

	$activity->setCarbohydratesPer5minutes(22);
	$CarbohydratesPer5minutes = $activity->getCarbohydratesPer5minutes();
	$this->assertEquals(22, $CarbohydratesPer5minutes);

	$activity->setRating(22);
	$Rating= $activity->getRating();
	$this->assertEquals(22, $Rating);

	
	   }
}
