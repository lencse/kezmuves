<?php

namespace Lencse\Blog\Component\Test\Content\Loader;


use Lencse\Blog\Adapter\Parser\PHPMarkdownParser;
use Lencse\Blog\Adapter\Parser\SymfonyYamlParser;
use Lencse\Blog\Component\Content\Loader\FileParser;
use Lencse\Blog\Component\Content\Loader\PostLoader;
use Lencse\Blog\Component\Content\PostTransformation;
use Lencse\Test\TestCase;

class PostLoaderTest extends TestCase
{

    public function testLoadPosts()
    {
        $loader = $this->getLoader(__DIR__ . '/Fixture/fixture');
        $posts = $loader->loadPosts();
        $this->assertEquals(3, $posts->getCount());
        $this->assertEquals('Lorem Ipsum', $posts->getPostBySlug('first-test-post')->getTitle());
        $this->assertEquals('Teszt kategória', $posts->getPostBySlug('first-test-post')->getCategory());
        $this->assertEquals(['tag1', 'tag2', 'tag3'], $posts->getPostBySlug('first-test-post')->getTags());
    }

    public function testForNotExistingContentDir()
    {
        $loader = $this->getLoader(__DIR__ . '/Fixture/fixture/NON-EXISTENT-DIR');
        $posts = $loader->loadPosts();
        $this->assertEquals(0, $posts->getCount());
    }

    /**
     * @return PostLoader
     */
    private function getLoader($path)
    {
        return new PostLoader(new FileParser(new PHPMarkdownParser(), new SymfonyYamlParser()), $path);
    }

}