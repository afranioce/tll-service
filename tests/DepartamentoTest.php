<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DepartamentoTest extends WebTestCase
{
    public function testIndex()
    {
        $client   = static::createClient();
        $crawler  = $client->request('GET', '/api/departamentos');

        $response = $crawler->getResponse();        
        $this->assertJsonResponse($response, 200);
    }

    public function testNew()
    {
        $client = static::createClient();

        $content = json_encode([
            'nome' => 'Tecnologia da informação'
        ]);
        
        $client->request('POST', '/api/departamentos', [], [], [], $content);
        $response = $crawler->getResponse();
        $this->assertJsonResponse($response, 200);
    }

    public function testEdit()
    {
        $client = static::createClient();

        $content = json_encode([
            'id' => 1,
            'nome' => 'Tecnologia da informação edit'
        ]);
        
        $client->request('PUT', '/api/departamentos/1', [], [], [], $content);
        $response = $crawler->getResponse();
        $this->assertJsonResponse($response, 200);
    }

    public function testDelete()
    {
        $client = static::createClient();

        $client->request('DELETE', '/api/departamentos/1');
        $response = $crawler->getResponse();
        $this->assertJsonResponse($response, 200);
    }

    protected function assertJsonResponse($response, $statusCode = 200)
    {
        $this->assertEquals(
            $statusCode, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }
}
