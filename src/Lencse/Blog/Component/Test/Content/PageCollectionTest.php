<?php

namespace Lencse\Blog\Component\Test\Content;


use Lencse\Blog\Component\Content\Page;
use Lencse\Blog\Component\Content\PageCollection;
use Lencse\Test\TestCase;

class PageCollectionTest extends TestCase
{

    /**
     * @var PageCollection
     */
    private $collection;

    /**
     * @var Page[]
     */
    private $pagesArray = [];

    protected function setUp()
    {
        $this->pagesArray = [
            $this->createPage('1', 3),
            $this->createPage('2', 1),
            $this->createPage('3', 4),
            $this->createPage('4', 2),
        ];
        $this->collection = new PageCollection();
        foreach ($this->pagesArray as $page) {
            $this->collection->addPage($page);
        }
    }

    /**
     * @param $slug int
     * @param $position int
     * @return Page
     */
    private function createPage($slug, $position)
    {
        $page = new Page();
        $page->setSlug($slug)->setPosition($position);

        return $page;
    }

    public function testGetBySlug()
    {
        $this->assertEquals($this->pagesArray[1], $this->collection->getPageBySlug('2'));
    }

    public function testExceptionForInvalidSlug()
    {
        try {
            $this->collection->getPageBySlug('invalid');
        }
        catch (\InvalidArgumentException $e) {
            return;
        }
        $this->fail('Excepted InvalidArgumentException');
    }

    public function testExceptionForDuplicatedSlug()
    {
        try {
            $this->collection->addPage($this->createPage('1', 0));
        }
        catch (\InvalidArgumentException $e) {
            return;
        }
        $this->fail('Excepted InvalidArgumentException');
    }


    public function testCount()
    {
        $this->assertEquals(4, $this->collection->getCount());
    }
    public function testOrderBy()
    {
        $map = [1, 3, 0, 2];
        foreach ($this->collection as $i => $page) {
            $this->assertEquals($this->pagesArray[$map[$i]], $page);
        }
    }

}