<?php

namespace Lencse\Blog\Component\Test\Content;


use Lencse\Blog\Component\Content\CategoryFilter;
use Lencse\Blog\Component\Content\Post;
use Lencse\Test\TestCase;

class CategoryFilterTest extends TestCase
{

    public function testFit()
    {
        $post = new Post();
        $post->setCategory('category');
        $filter1 = new CategoryFilter('category');
        $this->assertTrue($filter1->isFit($post));
        $filter2 = new CategoryFilter('othercategory');
        $this->assertFalse($filter2->isFit($post));
    }

}