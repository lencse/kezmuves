<?php

namespace Lencse\Blog\Component\Test\Content;


use Lencse\Blog\Component\Content\Post;
use Lencse\Blog\Component\Content\PostCollection;
use Lencse\Blog\Component\Content\PostRepository;
use Lencse\Test\TestCase;

class PostRepositoryTest extends TestCase
{

    /**
     * @var PostRepository
     */
    private $repository;

    /**
     * @var Post[]
     */
    private $postArray = [];

    protected function setUp()
    {
        $this->postArray = [
            $this->createPost('slug1', '-6min', 'Category1', ['tag1', 'tag2']),
            $this->createPost('slug2', '-8min', 'Category1', ['tag4']),
            $this->createPost('slug3', '-7min', 'Category3', ['tag1', 'tag3']),
            $this->createPost('slug4', '+1min', 'Category3', ['tag1', 'tag3']),
        ];
        $collection = new PostCollection();
        foreach ($this->postArray as $post) {
            $collection->addPost($post);
        }
        $this->repository = new PostRepository($collection);
    }

    /**
     * @param $slug
     * @param $dateString
     * @param $category
     * @param $tags
     * @return Post
     */
    private function createPost($slug, $dateString, $category, $tags)
    {
        $post = new Post();
        $post->setSlug($slug)
            ->setPublicationDate(new \DateTime($dateString))
            ->setCategory($category);
        foreach ($tags as $tag) {
            $post->addTag($tag);
        }

        return $post;
    }

    public function testGetAllOrderByDate()
    {
        $list = $this->repository->getAllOrderByDate();
        $this->assertEquals(3, $list->getCount());
        $map = [0, 2, 1];
        foreach ($list as $i => $post) {
            $this->assertEquals($this->postArray[$map[$i]], $post);
        }
    }

    public function testGetByCategoryOrderByDate()
    {
        $list = $this->repository->getByCategoryOrderByDate('Category1');
        $this->assertEquals(2, $list->getCount());
        $map = [0, 1];
        foreach ($list as $i => $post) {
            $this->assertEquals($this->postArray[$map[$i]], $post);
        }
    }

    public function testGetByTagOrderByDate()
    {
        $list = $this->repository->getByTagOrderByDate('tag1');
        $this->assertEquals(2, $list->getCount());
        $map = [0, 2];
        foreach ($list as $i => $post) {
            $this->assertEquals($this->postArray[$map[$i]], $post);
        }
    }

    public function testGetCategories()
    {
        $categories = $this->repository->getCategories();
        $this->assertEquals(2, count($categories));
        $this->assertContains('Category1', $categories);
        $this->assertContains('Category3', $categories);
    }

    public function testGetTags()
    {
        $tags = $this->repository->getTags();
        $this->assertEquals(4, count($tags));
        $this->assertContains('tag1', $tags);
        $this->assertContains('tag2', $tags);
        $this->assertContains('tag3', $tags);
        $this->assertContains('tag4', $tags);
    }

    public function testGetBySlug()
    {
        $this->assertEquals($this->postArray[0], $this->repository->getPostBySlug('slug1'));
        $this->assertEquals($this->postArray[3], $this->repository->getPostBySlug('slug4'));
    }

    public function testHasSlug()
    {
        $this->assertTrue($this->repository->hasPostWithSlug('slug1'));
        $this->assertFalse($this->repository->hasPostWithSlug('slug666'));
    }

}