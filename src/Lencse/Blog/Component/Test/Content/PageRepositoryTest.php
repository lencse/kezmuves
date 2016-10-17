<?php

namespace Lencse\Blog\Component\Test\Content;


use Lencse\Blog\Component\Content\Page;
use Lencse\Blog\Component\Content\PageCollection;
use Lencse\Blog\Component\Content\PageRepository;
use Lencse\Test\TestCase;

class PageRepositoryTest extends TestCase
{

    /**
     * @var PageRepository
     */
    private $repository;

    /**
     * @var Page[]
     */
    private $pageArray = [];

    protected function setUp()
    {
        $this->pageArray = [
            $this->createPage('slug1', 3),
            $this->createPage('slug2', 1),
            $this->createPage('slug3', 2),
        ];
        $collection = new PageCollection();
        foreach ($this->pageArray as $page) {
            $collection->addPage($page);
        }
        $this->repository = new PageRepository($collection);
    }

    /**
     * @param $slug
     * @param $position
     * @return Page
     */
    private function createPage($slug, $position)
    {
        $page = new Page();
        $page->setSlug($slug)->setPosition($position);

        return $page;
    }

    public function testGetAll()
    {
        $list = $this->repository->getAll();
        $this->assertEquals(3, $list->getCount());
        $map = [1, 2, 0];
        foreach ($list as $i => $page) {
            $this->assertEquals($this->pageArray[$map[$i]], $page);
        }
    }

    public function testGetBySlug()
    {
        $this->assertEquals($this->pageArray[0], $this->repository->getPageBySlug('slug1'));
        $this->assertEquals($this->pageArray[2], $this->repository->getPageBySlug('slug3'));
    }

    public function testHasSlug()
    {
        $this->assertTrue($this->repository->hasPageWithSlug('slug1'));
        $this->assertFalse($this->repository->hasPageWithSlug('slug666'));
    }

}