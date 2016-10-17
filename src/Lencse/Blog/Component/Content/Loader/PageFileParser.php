<?php

namespace Lencse\Blog\Component\Content\Loader;


use Lencse\Blog\Component\Content\Page;

class PageFileParser
{

    /**
     * @var MarkdownParser
     */
    private $markdownParser;

    /**
     * @var YamlParser
     */
    private $yamlParser;

    /**
     * @param MarkdownParser $markdownParser
     * @param YamlParser $yamlParser
     */
    public function __construct(MarkdownParser $markdownParser, YamlParser $yamlParser)
    {
        $this->markdownParser = $markdownParser;
        $this->yamlParser = $yamlParser;
    }

    /**
     * @param SplFileInfo $file
     * @return Page
     */
    public function parse(\SplFileInfo $file)
    {
        $html = $this->markdownParser->parse(file_get_contents($file->getRealPath()));
        $dom = new PageDom($html);
        $meta = $this->yamlParser->parse($dom->getMetaYaml());
        foreach (['slug', 'title', 'position'] as $key) {
            if (!array_key_exists($key, $meta)) {
                throw new \RuntimeException(sprintf("Key '%s' missing from meta in %s", $key, $file->getFilename()));
            }
        }
        $page = new Page();
        $page->setSlug($meta['slug'])
            ->setBody($dom->getHtml())
            ->setTitle($meta['title'])
            ->setPosition($meta['position']);

        return $page;
    }

}