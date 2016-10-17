<?php

namespace Lencse\Blog\Adapter\Parser;


use Lencse\Blog\Component\Content\Loader\YamlParser;
use Symfony\Component\Yaml\Parser;

class SymfonyYamlParser implements YamlParser
{

    /**
     * @var Parser
     */
    private $parser;

    public function __construct()
    {
        $this->parser = new Parser();
    }

    /**
     * @param $yaml
     * @return array
     */
    public function parse($yaml)
    {
        return $this->parser->parse($yaml);
    }

}