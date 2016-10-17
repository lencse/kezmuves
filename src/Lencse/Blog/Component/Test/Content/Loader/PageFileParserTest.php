<?php

namespace Lencse\Blog\Component\Test\Content\Loader;


use Lencse\Blog\Adapter\Parser\PHPMarkdownParser;
use Lencse\Blog\Adapter\Parser\SymfonyYamlParser;
use Lencse\Blog\Component\Content\Loader\PageFileParser;
use Lencse\Test\TestCase;

class PageFileParserTest extends TestCase
{

    public function testParse()
    {
        $page = $this->getParser()->parse(new \SplFileInfo(__DIR__ . '/Fixture/fixture/page-about.md'));
        $this->assertEquals('Ez itt a cím', $page->getTitle());
        $this->assertTrue(strpos($page->getBody(), '<p>Lorem ipsum') !== false);
        $this->assertEquals('page1', $page->getSlug());
    }

    /**
     * @return FileParser
     */
    private function getParser()
    {
        return new PageFileParser(new PHPMarkdownParser, new SymfonyYamlParser());
    }

}