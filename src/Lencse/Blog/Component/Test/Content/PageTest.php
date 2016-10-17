<?php

namespace Lencse\Blog\Component\Test\Content\Repository;


use Lencse\Blog\Component\Content\Page;
use Lencse\Test\TestCase;

class PageTest extends TestCase
{

    public function testTitle()
    {
        $page = new Page();
        $this->assertInstanceOf(Page::class, $page->setTitle('Title'));
        $this->assertEquals('Title', $page->getTitle());
    }

    public function testBody()
    {
        $page = new Page();
        $this->assertInstanceOf(Page::class, $page->setBody('Body'));
        $this->assertEquals('Body', $page->getBody());
    }

    public function testSlug()
    {
        $page = new Page();
        $this->assertInstanceOf(Page::class, $page->setSlug('slug'));
        $this->assertEquals('slug', $page->getSlug());
    }

    public function testPosiition()
    {
        $page = new Page();
        $this->assertInstanceOf(Page::class, $page->setPosition(2));
        $this->assertEquals(2, $page->getPosition());
    }
    
}