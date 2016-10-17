<?php

namespace Lencse\Blog\Component\Test\Content;


use Lencse\Blog\Component\Content\Post;
use Lencse\Blog\Component\Content\PostCollection;
use Lencse\Blog\Component\Content\PostComparator;
use Lencse\Blog\Component\Content\PostFilter;
use Lencse\Test\TestCase;

class TestFilter implements PostFilter
{

    public function isFit(Post $post)
    {
        return '2' == $post->getSlug();
    }

}

class TestComparator implements PostComparator
{

    public function compare(Post $post1, Post $post2)
    {
        return (int) $post1->getSlug() - (int) $post2->getSlug();
    }

}

class PostCollectionTest extends TestCase
{

    /**
     * @var PostCollection
     */
    private $collection;

    /**
     * @var $post[]
     */
    private $postArray = [];

    protected function setUp()
    {
        $this->postArray = [
            $this->createPost('3'),
            $this->createPost('1'),
            $this->createPost('4'),
            $this->createPost('2'),
        ];
        $this->collection = new PostCollection();
        foreach ($this->postArray as $post) {
            $this->collection->addPost($post);
        }
    }

    /**
     * @param $slug
     * @return Post
     */
    private function createPost($slug)
    {
        $post = new Post();
        $post->setSlug($slug);

        return $post;
    }

    public function testGetBySlug()
    {
        $this->assertEquals($this->postArray[1], $this->collection->getPostBySlug('1'));
    }

    public function testExceptionForInvalidSlug()
    {
        try {
            $this->collection->getPostBySlug('invalid');
        }
        catch (\InvalidArgumentException $e) {
            return;
        }
        $this->fail('Excepted InvalidArgumentException');
    }

    public function testExceptionForDuplicatedSlug()
    {
        try {
            $this->collection->addPost($this->createPost('1'));
        }
        catch (\InvalidArgumentException $e) {
            return;
        }
        $this->fail('Excepted InvalidArgumentException');
    }


    public function testTraverse()
    {
        foreach ($this->collection as $i => $post) {
            $this->assertEquals($this->postArray[$i], $post);
        }
    }

    public function testCount()
    {
        $this->assertEquals(4, $this->collection->getCount());
    }

    public function testFilter()
    {
        $filtered = $this->collection->filter(new TestFilter());
        $this->assertEquals(1, $filtered->getCount());
        $this->assertEquals($this->postArray[3], $filtered->current());
    }

    public function testOrderBy()
    {
        $ordered = $this->collection->orderBy(new TestComparator());
        $map = [1, 3, 0, 2];
        $this->assertEquals(4, $ordered->getCount());
        foreach ($ordered as $i => $post) {
            $this->assertEquals($this->postArray[$map[$i]], $post);
        }
    }

}