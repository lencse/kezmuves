<?php

namespace Lencse\Blog\Symfony\BlogBundle\Test\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @group expensive
 */
class BlogControllerTest extends WebTestCase
{

    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertContains('Valami', $client->getResponse()->getContent());
    }

    public function testShowPost()
    {
        $client = static::createClient();
        $client->request('GET', '/2016/07/15/valami');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Van valami', $response->getContent());
    }

    public function testShowPostRedirect()
    {
        $client = static::createClient();
        $client->request('GET', '/2016/00/00/valami');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testShowPostNotFound()
    {
        $client = static::createClient();
        $client->request('GET', '/2016/00/00/valami666');
        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }

    public function testListByTag()
    {
        $client = static::createClient();
        $client->request('GET', 'tag/tag2');
        $this->assertContains('Van valami', $client->getResponse()->getContent());
    }

    public function testListByCategory()
    {
        $client = static::createClient();
        $client->request('GET', 'category/Teszt%20kategória');
        $this->assertContains('Van valami', $client->getResponse()->getContent());
    }

    public function testShowPage()
    {
        $client = static::createClient();
        $client->request('GET', 'levente');
        $response = $client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Lencse', $response->getContent());
    }

}