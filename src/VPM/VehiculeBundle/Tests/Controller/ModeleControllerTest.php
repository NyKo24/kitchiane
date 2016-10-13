<?php

namespace VPM\VehiculeBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ModeleControllerTest extends WebTestCase
{
    public function testListe()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/modele/liste');
    }

    public function testAnnee()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/modele/annee');
    }

}
