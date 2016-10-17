<?php

namespace Lencse\Blog\Component\Test\Response;


use Lencse\Blog\Component\Content\Meta;
use Lencse\Blog\Component\Content\Page;
use Lencse\Blog\Component\Content\PageCollection;
use Lencse\Blog\Component\Content\Post;
use Lencse\Blog\Component\Content\PostCollection;
use Lencse\Blog\Component\Response\ResponseData;
use Lencse\Test\TestCase;

class ResponseDataTest extends TestCase
{

    public function testPostList()
    {
        $posts = new PostCollection();
        $post = new Post();
        $posts->addPost($post->setSlug('slug'));
        $response = new ResponseData();
        $this->assertInstanceOf(ResponseData::class, $response->setPostList($posts));
        $this->assertEquals($post, $response->getPostList()->getPostBySlug('slug'));
    }

    public function testAllPosts()
    {
        $posts = new PostCollection();
        $post = new Post();
        $posts->addPost($post->setSlug('slug'));
        $response = new ResponseData();
        $this->assertInstanceOf(ResponseData::class, $response->setAllPosts($posts));
        $this->assertEquals($post, $response->getAllPosts()->getPostBySlug('slug'));
    }

    public function testPages()
    {
        $pages = new PageCollection();
        $page = new Page();
        $pages->addPage($page->setSlug('slug'));
        $response = new ResponseData();
        $this->assertInstanceOf(ResponseData::class, $response->setPages($pages));
        $this->assertEquals($page, $response->getPages()->getPageBySlug('slug'));
    }

    public function testPost()
    {
        $post = new Post();
        $response = new ResponseData();
        $this->assertInstanceOf(ResponseData::class, $response->setPost($post->setSlug('1')));
        $this->assertEquals($post, $response->getPost());
    }

    public function testPage()
    {
        $page = new Page();
        $response = new ResponseData();
        $this->assertInstanceOf(ResponseData::class, $response->setPage($page->setSlug('1')));
        $this->assertEquals($page, $response->getPage());
    }

    public function testTag()
    {
        $response = new ResponseData();
        $this->assertInstanceOf(ResponseData::class, $response->setTag('tag'));
        $this->assertEquals('tag', $response->getTag());
    }

    public function testCategory()
    {
        $response = new ResponseData();
        $this->assertInstanceOf(ResponseData::class, $response->setCategory('category'));
        $this->assertEquals('category', $response->getCategory());
    }

    public function testTags()
    {
        $response = new ResponseData();
        $this->assertInstanceOf(ResponseData::class, $response->setTags(['tag1', 'tag2']));
        $this->assertEquals(['tag1', 'tag2'], $response->getTags());
    }

    public function testCategories()
    {
        $response = new ResponseData();
        $this->assertInstanceOf(ResponseData::class, $response->setCategories(['category1', 'category2']));
        $this->assertEquals(['category1', 'category2'], $response->getCategories());
    }

   public function testMeta()
    {
        $response = new ResponseData();
        $meta = new Meta();
        $meta->setTitle('Title');
        $this->assertInstanceOf(ResponseData::class, $response->setMeta($meta));
        $this->assertEquals('Title', $response->getMeta()->getTitle());
    }



}