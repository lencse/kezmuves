<?php

namespace Lencse\Blog\Component\Test\Content;


use Lencse\Blog\Component\Content\CategoryFilter;
use Lencse\Blog\Component\Content\Post;
use Lencse\Blog\Component\Content\PublishedFilter;
use Lencse\Blog\Component\Content\TagFilter;
use Lencse\Test\TestCase;

class PublishedFilterTest extends TestCase
{

    public function testFit()
    {
        $post1 = new Post();
        $post1->setPublicationDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2015-03-15 18:00:00'));
        $post2 = new Post();
        $post2->setPublicationDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2030-03-15 18:00:00'));
        $filter = new PublishedFilter();
        $this->assertTrue($filter->isFit($post1));
        $this->assertFalse($filter->isFit($post2));
    }

}