<?php

namespace Lencse\Blog\Component\Test\Content\Repository;


use Lencse\Blog\Component\Content\Meta;
use Lencse\Test\TestCase;

class MetaTest extends TestCase
{

    public function testTitle()
    {
        $meta = new Meta();
        $this->assertInstanceOf(Meta::class, $meta->setTitle('Title'));
        $this->assertEquals('Title', $meta->getTitle());
    }

    public function testUrl()
    {
        $meta = new Meta();
        $this->assertInstanceOf(Meta::class, $meta->setUrl('Url'));
        $this->assertEquals('Url', $meta->getUrl());
    }

    public function testImage()
    {
        $meta = new Meta();
        $this->assertInstanceOf(Meta::class, $meta->setImage('Image'));
        $this->assertEquals('Image', $meta->getImage());
    }

    public function testDescription()
    {
        $meta = new Meta();
        $this->assertInstanceOf(Meta::class, $meta->setDescription('Description'));
        $this->assertEquals('Description', $meta->getDescription());
    }

    public function testType()
    {
        $meta = new Meta();
        $this->assertInstanceOf(Meta::class, $meta->setType('Type'));
        $this->assertEquals('Type', $meta->getType());
    }

}