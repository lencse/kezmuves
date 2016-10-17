<?php

namespace Lencse\Blog\Component\Test\Content;


use Lencse\Blog\Component\Content\CategoryFilter;
use Lencse\Blog\Component\Content\Post;
use Lencse\Blog\Component\Content\TagFilter;
use Lencse\Test\TestCase;

class TagFilterTest extends TestCase
{

    public function testFit()
    {
        $post = new Post();
        $post->addTag('tag1')->addTag('tag2');
        $filter1 = new TagFilter('tag1');
        $filter2 = new TagFilter('tag2');
        $filter3 = new TagFilter('tag3');
        $this->assertTrue($filter1->isFit($post));
        $this->assertTrue($filter2->isFit($post));
        $this->assertFalse($filter3->isFit($post));
    }

}