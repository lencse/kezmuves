<?php

namespace Lencse\Blog\Component\Content\Loader;


interface YamlParser
{

    /**
     * @param $yaml
     * @return array
     */
    public function parse($yaml);

}