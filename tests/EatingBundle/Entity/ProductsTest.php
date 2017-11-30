<?php

namespace EatingBundle\Entity;

use PHPUnit\Framework\TestCase;

class ProductsTest extends TestCase
{
    public function testAdd()
    {
        $product = new Products();

        $product->setName("lalala");
        $Name = $product->getName();
        $this->assertEquals("lalala", $Name);

        $product->setKkalPer100gr(11);
        $KkalPer100gr = $product->getKkalPer100gr();
        $this->assertEquals(11, $KkalPer100gr);

        $product->setProteinsPer100gr(22);
        $ProteinsPer100gr = $product->getProteinsPer100gr();
        $this->assertEquals(22, $ProteinsPer100gr);

        $product->setFatsPer100gr(22);
        $FatsPer100gr = $product->getFatsPer100gr();
        $this->assertEquals(22, $FatsPer100gr);

        $product->setCarbohydratesPer100gr(22);
        $CarbohydratesPer100gr = $product->getFatsPer100gr();
        $this->assertEquals(22, $CarbohydratesPer100gr);

        $product->setRating(22);
        $Rating= $product->getRating();
        $this->assertEquals(22, $Rating);

        $product->setCreatedAt(22);
        $CreatedAt= $product->getCreatedAt();
        $this->assertEquals(22, $CreatedAt);
    }
}
