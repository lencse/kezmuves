<?php

namespace Lencse\Blog\Adapter\Parser;


use Lencse\Blog\Component\Content\Loader\MarkdownParser;
use Michelf\MarkdownExtra;

class PHPMarkdownParser implements MarkdownParser
{

    /**
     * @param string $markdown
     * @return string
     */
    public function parse($markdown)
    {
        return MarkdownExtra::defaultTransform($markdown);
    }


}