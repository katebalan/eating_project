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

        $this->assertEquals(
            200,
            $client->getResponse()->getStatusCode()
        );
    }
}
