<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Nouvelle demande', $crawler->filter('h1')->text());
    }

    public function testIndexFormSubmission()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/');

        $form = $crawler->selectButton('Envoyer')->form();
        $form['application[userNumber]'] = '123123123123';

        // submit the form
        $crawler = $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Cette valeur ne doit pas être vide', $crawler->filter('body')->text());
    }
}
