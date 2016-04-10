<?php

namespace Levi9\BatteriesBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Client;
use Doctrine\ORM\EntityManager;
use BatteriesBundle\Entity\Battery;

class BatteriesControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();
    }

    /**
     * @dataProvider addProvider
     */
    public function testAdd($type, $count)
    {
        $crawler = $this->client->request(Request::METHOD_GET, '/add');
        $form = $crawler->selectButton('Save')->form();

        $form['battery[type]'] = $type;
        $form['battery[count]'] = $count;
        $this->client->submit($form);

        $this->assertTrue($this->client->getResponse()->isRedirect('/'));
    }

    /**
     * @return array
     */
    public function addProvider()
    {
        return [
            ['AA', 4],
            ['AAA', 3],
            ['AA', 1],
        ];
    }

    public function testStatistics()
    {
        $this->insertDataToDb();

        $crawler = $this->client->request(Request::METHOD_GET, '/');

        $this->assertEquals(
            $crawler->filter('tbody tr')->count(),
            2
        );

        $this->assertEquals(
            $crawler->filter('td:contains("aaa")')->siblings()->text(),
            5
        );

        $this->assertEquals(
            $crawler->filter('td:contains("bbb")')->siblings()->text(),
            3
        );
    }

    public function tearDown()
    {
        $this->entityManager->getRepository('BatteriesBundle:Battery')->deleteAll();
    }

    private function insertDataToDb()
    {
        $batteries[0] = new Battery();
        $batteries[0]->setType('aaa');
        $batteries[0]->setCount(1);

        $batteries[1] = new Battery();
        $batteries[1]->setType('bbb');
        $batteries[1]->setCount(3);

        $batteries[2] = new Battery();
        $batteries[2]->setType('aaa');
        $batteries[2]->setCount(4);

        $i = count($batteries);
        while($i--) {
            $this->entityManager->persist($batteries[$i]);
        }

        $this->entityManager->flush();
    }
}
