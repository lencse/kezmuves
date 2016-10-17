<?php

namespace Lencse\Blog\Component\Content\Loader;


use Lencse\Blog\Component\Content\PageCollection;

class PageLoader
{

    /**
     * @var PageCollection
     */
    private $pages;

    /**
     * @param FileParser $parser
     * @param $path string
     */
    public function __construct(PageFileParser $parser, $path)
    {
        $this->pages = new PageCollection();
        $separator = '\\' . DIRECTORY_SEPARATOR;
        if (!file_exists($path)) {
            return;
        }
        $iterator = new \FilesystemIterator($path);
        $pageFiles = new \RegexIterator($iterator, '|' . $separator . 'page-[^' . $separator . ']*\.md$|');
        foreach ($pageFiles as $file) {
            $this->pages->addPage($parser->parse($file));
        }
    }

    /**
     * @return PageCollection
     */
    public function loadPages()
    {
        return $this->pages;
    }

}