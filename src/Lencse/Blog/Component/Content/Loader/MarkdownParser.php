<?php

namespace Lencse\Blog\Component\Content\Loader;


interface MarkdownParser
{

    /**
     * @param $markdown string
     * @return string
     */
    public function parse($markdown);

}