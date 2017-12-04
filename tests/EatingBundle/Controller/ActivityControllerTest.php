<?php

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use EatingBundle\Entity\Activity;

class ActivityControllerTest extends WebTestCase
{
    public function testShowList() {
        $client = self::createClient();

        $crawler = $client->request('GET', '/activity');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("Proteins")')->count()
        );
    }

    public function testNewActivity() {
        $client = self::createClient();

        $crawler = $client->request('GET', '/activity/new');

        $buttonCrawlerNode = $crawler->selectButton('submit');

//        $form = $buttonCrawlerNode->form( array());
//
//        $form['name'] = 'Fabien';
//        $form['kkal_per_5minutes'] = '500';
//        $form['proteins_per_5minutes'] = '20';
//        $form['fats_per_5minutes'] = '20';
//        $form['carbohydrates_per_5minutes'] = 'Fabien20';
//
//        $client->submit($form);

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }
}
