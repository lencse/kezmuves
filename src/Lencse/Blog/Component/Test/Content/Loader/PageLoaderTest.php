<?php

namespace Lencse\Blog\Component\Test\Content\Loader;


use Lencse\Blog\Adapter\Parser\PHPMarkdownParser;
use Lencse\Blog\Adapter\Parser\SymfonyYamlParser;
use Lencse\Blog\Component\Content\Loader\PageFileParser;
use Lencse\Blog\Component\Content\Loader\PageLoader;
use Lencse\Test\TestCase;

class PageLoaderTest extends TestCase
{

    public function testLoadPosts()
    {
        $loader = $this->getLoader(__DIR__ . '/Fixture/fixture');
        $pages = $loader->loadPages();
        $this->assertEquals(2, $pages->getCount());
        $this->assertEquals('Ez itt a cím', $pages->getPageBySlug('page1')->getTitle());
        $this->assertEquals('Másik cím', $pages->getPageBySlug('page2')->getTitle());
    }

    public function testForNotExistingContentDir()
    {
        $loader = $this->getLoader(__DIR__ . '/Fixture/fixture/NON-EXISTENT-DIR');
        $pages = $loader->loadPages();
        $this->assertEquals(0, $pages->getCount());
    }

    /**
     * @return PageLoader
     */
    private function getLoader($path)
    {
        return new PageLoader(new PageFileParser(new PHPMarkdownParser(), new SymfonyYamlParser()), $path);
    }

}