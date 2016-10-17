<?php

namespace Lencse\Blog\Component\Test\Content\Loader;


use Lencse\Blog\Adapter\Parser\PHPMarkdownParser;
use Lencse\Blog\Adapter\Parser\SymfonyYamlParser;
use Lencse\Blog\Component\Content\Loader\FileParser;
use Lencse\Test\TestCase;

class FileParserTest extends TestCase
{

    public function testParse()
    {
        $post = $this->getParser()->parse(new \SplFileInfo(__DIR__ . '/Fixture/fixture/post-post1.md'));
        $this->assertEquals('Lorem Ipsum', $post->getTitle());
        $this->assertTrue(strpos($post->getBody(), 'Lorem ipsum dolor <em>sit amet</em>') !== false);
        $this->assertEquals('first-test-post', $post->getSlug());
    }

    public function testExceptionForWrongFile()
    {
        try {
            $this->getParser()->parse(new \SplFileInfo(__DIR__ . '/Fixture/error/post-post1.md'));
        }
        catch (\RuntimeException $e) {
            return;
        }
        $this->fail('Excepted RuntimeException');
    }

    /**
     * @return FileParser
     */
    private function getParser()
    {
        return new FileParser(new PHPMarkdownParser, new SymfonyYamlParser());
    }

}