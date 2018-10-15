<?php

namespace Tests\EatingBundle\Controller\Api;

use Tests\EatingBundle\DoctrineTestCase;


/**
 * Class ProductControllerTest
 * @package Tests\IMS\WebportalRESTBundle
 */
class ProductControllerTest extends DoctrineTestCase
{
    public function testGetProducts()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/product');
        $response = $client->getResponse();

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'HTTP code is not 200');
    }


    public function testGetProduct()
    {
        $client = static::createClient();
        $element = $this->getElement('EatingBundle:Products');

        $crawler = $client->request('GET', '/api/product/'.$element->getId());
        $response = $client->getResponse();

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'HTTP code is not 200');
    }

    public function testPostProduct()
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/api/product/new', array(
            'name' => 'FOOD',
            'kkal' => '156',
            'proteins' => 56,
            'fats' => 65,
            'carbohydrates' => 42,
            'rating' => 2,
        ));
        $response = $client->getResponse();
//        echo $response;

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'HTTP code is not 200');
    }

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

    public function testDeleteProduct()
    {
        $client = static::createClient();
        $element = $this->getElement('EatingBundle:Products', 'DESC');

        $crawler = $client->request('DELETE', '/api/product/'.$element->getId());

        $response = $client->getResponse();
//        echo $response;

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), 'HTTP code is not 200');
    }

//
//    /**
//     * Test for ContactProfileApiController::getAction($id)
//     *
//     * @call: ./vendor/bin/phpunit --filter testContactPersonGET tests/IMS/WebportalRESTBundle/ApiCallsTest.php
//     */
//    public function testContactProfileGET()
//    {
//        $client = static::createClient();
//        $element = $this->getElement('IMSCCSBundle:ContactProfile');
//
//        $crawler = $client->request('GET', '/api/webportal/contact/profile/'.$element->getId());
//
//        $response = $client->getResponse();
//        $this->assertJsonResponse($response, 200);
//    }
//
//    /**
//     * Test for BaseDossierApiController::getShowAction($id)
//     *
//     * @call: ./vendor/bin/phpunit --filter testDossierShowGET tests/IMS/WebportalRESTBundle/ApiCallsTest.php
//     */
//    public function testDossierShowGET()
//    {
//        $client = static::createClient();
//        $element = $this->getElement('IMSCCSBundle:BaseDossier');
//
//        $crawler = $client->request(
//            'GET',
//            '/api/webportal/dossier/shows/'.$element->getId(),
//            array('office_code' => $element->getCustomer()->getOfficeCode())
//        );
//
//        $response = $client->getResponse();
//        $this->assertJsonResponse($response, 200);
//    }
//
//    /**
//     * Test for BaseDossierApiController::getAction($id)
//     *
//     * @call: ./vendor/bin/phpunit --filter testDossierGET tests/IMS/WebportalRESTBundle/ApiCallsTest.php
//     */
//    public function testDossierGET()
//    {
//        $client = static::createClient();
//        $element = $this->getElement('IMSCCSBundle:BaseDossier');
//
//        $crawler = $client->request(
//            'GET',
//            '/api/webportal/dossier/'.$element->getId(),
//            array('office_code' => $element->getCustomer()->getOfficeCode())
//        );
//
//        $response = $client->getResponse();
//        $this->assertJsonResponse($response, 200);
//
//        $crawler = $client->request(
//            'GET',
//            '/api/webportal/dossier/'.$element->getId(),
//            array('office_code' => 'aaaaa')
//        );
//
//        $response = $client->getResponse();
//        $this->assertJsonResponse($response, 403);
//    }
//
//    /**
//     * Test for CarApiController::postAction($dossierId)
//     *
//     * @call: ./vendor/bin/phpunit --filter testCarPOST tests/IMS/WebportalRESTBundle/ApiCallsTest.php
//     * @throws \Doctrine\ORM\ORMException
//     */
//    public function testCarPOST()
//    {
//        $test_year = (string)random_int(0000, 9999);
//        $client = static::createClient();
//        $element = $this->getElement('IMSCCSBundle:BaseDossier');
//
//        $crawler = $client->request('POST', '/api/webportal/car/'.$element->getId(), array(
//            'type' => '1',
//            'model' => '1',
//            'chassis' => 'WDB6591041K17'.$test_year,
//            'numberChassis' => '2',
//            'year' => '2006',
//            'status' => 2,
//            'tracked' => 1
//        ));
//
//        $response = $client->getResponse();
//        $this->assertJsonResponse($response, 200);
//
//        $newElement = $this->getElement('IMSCCSBundle:Car', 'DESC');
//        $this->em->refresh($newElement);
//        $this->assertEquals('WDB6591041K17'.$test_year, $newElement->getChassis());
//    }
//
//    /**
//     * Test for CarApiController::putAction($id)
//     *
//     * @call: ./vendor/bin/phpunit --filter testCarPUT tests/IMS/WebportalRESTBundle/ApiCallsTest.php
//     * @throws \Doctrine\ORM\ORMException
//     */
//    public function testCarPUT()
//    {
//        $client = static::createClient();
//        $test_year = random_int(1990, 2018);
//        $element = $this->getElement('IMSCCSBundle:Car', 'DESC');
//        $office_code = $element->getDetailedDossier()->getBaseDossier()->getCustomer()->getOfficeCode();
//
//        $crawler = $client->request(
//            'PUT',
//            '/api/webportal/car/'.$element->getId().'?office_code='.$office_code,
//            array(
//                'type' => $element->getType()->getId(),
//                'model' => $element->getModel()->getId(),
//                'chassis' => $element->getChassis(),
//                'numberChassis' => 2,
//                'year' => $test_year,
//                'status' => 2,
//                'weight' => 0,
//                'changedBy' => 'admin@admin.com',
//                'tracked' => 1,
//            )
//        );
//
//        $response = $client->getResponse();
//        $this->assertJsonResponse($response, 200);
//
//        $newElement = $this->getElement('IMSCCSBundle:Car', 'DESC');
//        $this->em->refresh($newElement);
//        $this->assertEquals($test_year, $newElement->getYear());
//    }
//
//
//    /**
//     * Test for ContactProfileApiController::postShipperAction()
//     *
//     * @call: ./vendor/bin/phpunit --filter testContactProfileShippersPOST tests/IMS/WebportalRESTBundle/ApiCallsTest.php
//     */
//    public function testContactProfileShippersPOST()
//    {
//        $client = static::createClient();
//        $element = $this->getElement('IMSCCSBundle:Country');
//
//        $crawler = $client->request('POST', '/api/webportal/contact/profile/shippers', array(
//            'name' => 'TEST',
//            'street' => 'Test street',
//            'country_id' => $element->getId(),
//            'office_code' => 'IMS',
//            'department' => 'aa'
//        ));
//
//        $response = $client->getResponse();
//        $this->assertJsonResponse($response, 200);
//    }
//
//    /**
//     * Test for ContactProfileApiController::putShipperAction($id)
//     *
//     * @call: ./vendor/bin/phpunit --filter testContactProfileShippersPUT tests/IMS/WebportalRESTBundle/ApiCallsTest.php
//     * @throws \Doctrine\ORM\ORMException
//     */
//    public function testContactProfileShippersPUT()
//    {
//        $client = static::createClient();
//        $newStreet = 'New street';
//        $element = $this->getElement('IMSCCSBundle:ContactProfile', 'DESC');
//
//        $crawler = $client->request(
//            'PUT',
//            '/api/webportal/contact/profile/shippers/'.$element->getId(),
//            array(
//                'id' => $element->getId(),
//                'name' => $element->getName(),
//                'street' => $newStreet,
//                'country_id' => $element->getCountry()->getId(),
//                'office_code' => 'IMS',
//                'department' => 'aa',
//            )
//        );
//
//        $response = $client->getResponse();
//        $this->assertJsonResponse($response, 200);
//
//        $newElement = $this->getElement('IMSCCSBundle:ContactProfile', 'DESC');
//        $this->em->refresh($newElement);
//        $this->assertEquals($newStreet, $newElement->getStreet());
//    }
//
//    /**
//     * Test for ContactPersonApiController::postAction()
//     *
//     * @call: ./vendor/bin/phpunit --filter testContactPersonPOST tests/IMS/WebportalRESTBundle/ApiCallsTest.php
//     * @throws \Doctrine\ORM\ORMException
//     */
//    public function testContactPersonPOST()
//    {
//        $test_name = 'Test person';
//        $client = static::createClient();
//        $element = $this->getElement('IMSCCSBundle:Country');
//
//        $crawler = $client->request(
//            'POST',
//            '/api/webportal/contact/person',
//            array(
//                'ims_ccsbundle_contactpersontype' => [
//                    'name' => $test_name,
//                    'email' => 'test@email.com',
//                    'phone_number' => '103',
//                    'country' => $element->getId(),
//                    'city' => 'Test City'
//                ]
//            )
//        );
//
//        $response = $client->getResponse();
//        $this->assertJsonResponse($response, 200);
//
//        $newElement = $this->getElement('IMSCCSBundle:ContactPerson', 'DESC');
//        $this->em->refresh($newElement);
//        $this->assertEquals($test_name, $newElement->getName());
//    }
//
//    /**
//     * Test for ContactPersonApiController::putAction($id)
//     *
//     * @call: ./vendor/bin/phpunit --filter testContactPersonPUT tests/IMS/WebportalRESTBundle/ApiCallsTest.php
//     * @throws \Doctrine\ORM\ORMException
//     */
//    public function testContactPersonPUT()
//    {
//        $test_name = 'New person\'s name';
//        $client = static::createClient();
//        $element = $this->getElement('IMSCCSBundle:ContactPerson', 'DESC');
//
//        $crawler = $client->request(
//            'PUT',
//            '/api/webportal/contact/person/'.$element->getId(),
//            array(
//                'ims_ccsbundle_contactpersontype' => [
//                    'id' => $element->getId(),
//                    'name' => $test_name,
//                    'email' => $element->getEmail(),
//                    'phone_number' => $element->getPhoneNumber(),
//                    'country' => $element->getCountry()->getId(),
//                    'city' => $element->getCity()
//                ],
//                'type' => 'consigneer'
//            )
//        );
//
//        $response = $client->getResponse();
//        $this->assertJsonResponse($response, 200);
//
//        $newElement = $this->getElement('IMSCCSBundle:ContactPerson', 'DESC');
//        $this->em->refresh($newElement);
//        $this->assertEquals($test_name, $newElement->getName());
//    }
//
//    /**
//     * Test for BaseDossierApiController::postAction()
//     *
//     * @call: ./vendor/bin/phpunit --filter testDossierPOST tests/IMS/WebportalRESTBundle/ApiCallsTest.php
//     * @throws \Doctrine\ORM\ORMException
//     */
//    public function testDossierPOST()
//    {
//        $client = static::createClient();
//        $pol = $this->getElement('IMSCCSBundle:Port');
//        $pod = $this->getElement('IMSCCSBundle:Port', 'DESC');
//
//        $crawler = $client->request(
//            'POST',
//            '/api/webportal/dossier',
//            array(
//                'ims_ccsbundle_basedossiertype' => [
//                    'pol' => $pol->getId(),
//                    'pod' => $pod->getId(),
//                    'departureId' => 1,
//                    'asAgent' => 'AS AGENTS ONLY',
//                    'consigneer' => 1,
//                    'shipper' => 1,
//                    'customer' => 'IMS',
//                ],
//            )
//        );
//
//        $response = $client->getResponse();
//        $this->assertJsonResponse($response, 200);
//
//        $newElement = $this->getElement('IMSCCSBundle:BaseDossier', 'DESC');
//        $this->em->refresh($newElement);
//        $this->assertEquals($pol->getId(), $newElement->getPol()->getId());
//        $this->assertEquals($pod->getId(), $newElement->getPod()->getId());
//    }
//
//    /**
//     * Test for BaseDossierApiController::putAction($id)
//     *
//     * @call: ./vendor/bin/phpunit --filter testDossierPUT tests/IMS/WebportalRESTBundle/ApiCallsTest.php
//     * @throws \Doctrine\ORM\ORMException
//     */
//    public function testDossierPUT()
//    {
//        $client = static::createClient();
//        $element = $this->getElement('IMSCCSBundle:BaseDossier', 'DESC');
//        $newPol = $element->getPod()->getId();
//        $newPod = $element->getPol()->getId();
//
//        $crawler = $client->request(
//            'PUT',
//            '/api/webportal/dossier/'.$element->getId(),
//            array(
//                'ims_ccsbundle_basedossiertype' => [
//                    'pol' => $newPol,
//                    'pod' => $newPod,
//                    'departureId' => $element->getDepartureId()->getId(),
//                    'consigneer' => $element->getConsigneer()->getId(),
//                    'shipper' => $element->getShipper()->getId(),
//                    'customer' => $element->getCustomer()->getId()
//                ],
//                'office_code' => 'IMS'
//            )
//        );
//
//        $response = $client->getResponse();
//        $this->assertJsonResponse($response, 200);
//
//        $newElement = $this->getElement('IMSCCSBundle:BaseDossier', 'DESC');
//        $this->em->refresh($newElement);
//        $this->assertEquals($newPol, $newElement->getPol()->getId());
//        $this->assertEquals($newPod, $newElement->getPod()->getId());
//    }
//
////    public function testDocsPOST()
////    {
////        $client = static::createClient();
////        $crawler = $client->request('POST', '/api/webportal/contact/person/'.self::DOSSIER_ID);
////
////        $response = $client->getResponse();
////        $this->assertJsonResponse($response, 200);
////    }
//
//    /**
//     * Check response status code (200)
//     *
//     * @param $response
//     * @param int $statusCode
//     */
//    protected function assertJsonResponse($response, $statusCode = 200)
//    {
//        if (is_array(json_decode($response->getContent(), true))
//            && array_key_exists('content', json_decode($response->getContent(), true))
//            && array_key_exists('code', json_decode(json_decode($response->getContent(), true)['content'], true))) {
//            $this->assertEquals(
//                $statusCode,
//                json_decode(json_decode($response->getContent(), true)['content'], true)['code'],
//                $response->getContent()
//            );
//        }
//        $this->assertEquals(
//            $statusCode,
//            $response->getStatusCode()
//        );
//        $this->assertTrue(
//            $response->headers->contains('Content-Type', 'application/json'),
//            $response->headers
//        );
//    }
//
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
