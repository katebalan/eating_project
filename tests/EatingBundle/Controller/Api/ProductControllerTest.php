<?php

namespace Tests\EatingBundle\Controller\Api;

use Tests\EatingBundle\DoctrineTestCase;


/**
 * Class ProductControllerTest
 * @package Tests\IMS\WebportalRESTBundle
 */
class ProductControllerTest extends DoctrineTestCase
{
    /**
     * Test: get list of objects
     */
//    public function testGetProducts()
//    {
//        $client = static::createClient();
//
//        $crawler = $client->request('GET', '/api/product');
//        $response = $client->getResponse();
//
//        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'HTTP code is not 200');
//    }

    /**
     * Test: get object by id
     */
    public function testGetProduct()
    {
        $client = static::createClient();
        $element = $this->getElement('EatingBundle:Products');

        $crawler = $client->request('GET', '/api/product/'.$element->getId());
        $response = $client->getResponse();

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'HTTP code is not 200');
    }

    /**
     * Test: add new object
     */
//    public function testPostProduct()
//    {
//        $client = static::createClient();
//
//        $crawler = $client->request('POST', '/api/product/new', array(
//            'name' => 'FOOD',
//            'kkal' => '156',
//            'proteins' => 56,
//            'fats' => 65,
//            'carbohydrates' => 42,
//            'rating' => 2,
//        ));
//        $response = $client->getResponse();
//
//        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'HTTP code is not 200');
//    }

    /**
     * Test: update existed object
     */
    public function testPutProduct()
    {
        $client = static::createClient();
        $element = $this->getElement('EatingBundle:Products', 'DESC');

        $name = 'FOOD2';
        $kkal = 25;
        $proteins = 5;
        $fats = 6;
        $carbohydrates = 4;
        $rating = 5;
        $crawler = $client->request('PUT', '/api/product/'.$element->getId(), array(
            'name' => $name,
            'kkal' => $kkal,
            'proteins' => $proteins,
            'fats' => $fats,
            'carbohydrates' => $carbohydrates,
            'rating' => $rating,
        ));

        $response = $client->getResponse();

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'HTTP code is not 200');

        $newElement = $this->getElement('EatingBundle:Products', 'DESC');
        $this->em->refresh($newElement);
        $this->assertEquals($name, $newElement->getName());
        $this->assertEquals($kkal, $newElement->getKkalPer100gr());
    }

    /**
     * Test: delete existed object
     */
    public function testDeleteProduct()
    {
        $client = static::createClient();
        $element = $this->getElement('EatingBundle:Products', 'DESC');

        $crawler = $client->request('DELETE', '/api/product/'.$element->getId());

        $response = $client->getResponse();

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'HTTP code is not 200');
    }

    /**
     * Get one element from database
     *
     * @param $repository
     * @param string $order
     * @return mixed
     */
    protected function getElement($repository, $order = 'ASC')
    {
        $entity = $this->em->getRepository($repository);

        $results = $entity
            ->createQueryBuilder('a')
            ->setMaxResults(1)
            ->orderBy('a.id', $order)
            ->getQuery()
            ->execute();
        return $results[0];
    }
}
