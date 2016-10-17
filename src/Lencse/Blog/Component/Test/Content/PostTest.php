<?php

namespace Lencse\Blog\Component\Test\Content\Repository;


use Lencse\Blog\Component\Content\Post;
use Lencse\Test\TestCase;

class PostTest extends TestCase
{

    public function testTitle()
    {
        $post = new Post();
        $this->assertInstanceOf(Post::class, $post->setTitle('Title'));
        $this->assertEquals('Title', $post->getTitle());
    }

    public function testBody()
    {
        $post = new Post();
        $this->assertInstanceOf(Post::class, $post->setBody('Body'));
        $this->assertEquals('Body', $post->getBody());
    }

    public function testCategory()
    {
        $post = new Post();
        $this->assertInstanceOf(Post::class, $post->setCategory('Category'));
        $this->assertEquals('Category', $post->getCategory());
    }

    public function testSlug()
    {
        $post = new Post();
        $this->assertInstanceOf(Post::class, $post->setSlug('slug'));
        $this->assertEquals('slug', $post->getSlug());
    }

    public function testFeaturedImage()
    {
        $post = new Post();
        $this->assertInstanceOf(Post::class, $post->setFeaturedImage('dummy/image.jpg'));
        $this->assertEquals('dummy/image.jpg', $post->getFeaturedImage());
    }

    public function testPublicationDate()
    {
        $post = new Post();
        $formatStr = 'Y-m-d H:i:s';
        $dateStr = '2016-03-15 18:00:00';
        $this->assertInstanceOf(Post::class, $post->setPublicationDate(\DateTime::createFromFormat($formatStr, $dateStr)));
        $this->assertEquals(\DateTime::createFromFormat($formatStr, $dateStr), $post->getPublicationDate());
    }

    public function testPublicationDateInUrl()
    {
        $post = new Post();
        $post->setPublicationDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2016-03-15 18:00:00'));
        $this->assertEquals('2016/03/15', $post->getPublicationDateInUrl());
    }

    public function testHasLeadWithMoreLink()
    {
        $post = new Post();
        $post->setBody('<h1>Title</h1><p>Lead</p><!-- MORE --><p>Content</p>');
        $this->assertTrue($post->hasLead());
    }

    public function testLeadWithMoreLink()
    {
        $post = new Post();
        $post->setBody('<h1>Title</h1><p>Lead</p><!-- MORE --><p>Content</p>');
        $this->assertEquals('<h1>Title</h1><p>Lead</p>', $post->getLead());
    }

    public function testHasLeadWithoutMoreLink()
    {
        $post = new Post();
        $post->setBody('<h1>Title</h1><p>Lead</p><p>Content</p>');
        $this->assertFalse($post->hasLead());
    }

    public function testLeadWithoutMoreLink()
    {
        $post = new Post();
        $post->setBody('<h1>Title</h1><p>Lead</p><p>Content</p>');
        $this->assertEquals('<h1>Title</h1><p>Lead</p><p>Content</p>', $post->getLead());
    }

    public function testTags()
    {
        $post = new Post();
        $this->assertInstanceOf(Post::class, $post->addTag('tag1')->addTag('tag2'));
        $this->assertEquals(['tag1', 'tag2'], $post->getTags());
    }

    public function testPublished()
    {
        $post = new Post();
        $post->setPublicationDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2015-03-15 18:00:00'));
        $this->assertTrue($post->isPublished());
    }

    public function testNotPublished()
    {
        $post = new Post();
        $post->setPublicationDate(\DateTime::createFromFormat('Y-m-d H:i:s', '2030-03-15 18:00:00'));
        $this->assertFalse($post->isPublished());
    }

}