<?php
/**
 * Created by PhpStorm.
 * User: katya
 * Date: 04.12.17
 * Time: 16:43
 */

namespace AppBundle\Entity;


use PHPUnit\Framework\TestCase;

class GenusTest extends TestCase
{
    public function testAdd()
    {
        $genus = new Genus();

        $id = $genus->getId();
        $this->assertNull($id);

        $genus->setName('lala');
        $this->assertEquals('lala', $genus->getName());

        $genus->setSpeciesCount('100');
        $this->assertEquals('100', $genus->getSpeciesCount());

        $genus->setIsPublished(true);
        $this->assertEquals(true, $genus->getisPublished());

        $genus->setFunFact('juhvfjn holn juh jklnoku');
        $this->assertEquals('juhvfjn holn juh jklnoku', $genus->getFunFact());

        $genus->setFirstDiscoveredAt('lala');
        $this->assertEquals('lala', $genus->getFirstDiscoveredAt());

        $this->assertNotNull($genus->getUpdatedAt());

        $subfamily = new SubFamily();
        $subfamily->setName('SUBFAMILY');

        $genus->setSubFamily($subfamily);
        $this->assertEquals($subfamily, $genus->getSubFamily());

        $this->assertNull($genus->getNotes());

//        $this->assertArrayNotHasKey('notes', $genus->getNotes());
    }
}