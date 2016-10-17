<?php

namespace Lencse\Blog\Component\Content\Loader;


class PageDom
{

    /**
     * @var \DOMDocument
     */
    private $dom;

    /**
     * @var \DOMElement
     */
    private $mainDiv;

    /**
     * @var string
     */
    private $metaYaml;

    /**
     * @param $html
     */
    function __construct($html)
    {
        $this->dom = new \DOMDocument();
        $this->dom->loadHTML('<?xml encoding="utf-8" ?><div>' . $html . '</div>');
        $this->mainDiv = $this->dom->getElementsByTagName('div')->item(0);

        $xpath = new \DOMXPath($this->dom);
        $commentNode = $xpath->query('//comment()')->item(0);
        $commentNode->parentNode->removeChild($commentNode);
        $this->metaYaml = trim($commentNode->nodeValue);
    }

    /**
     * @return string
     */
    public function getMetaYaml()
    {
        return $this->metaYaml;
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        $html = $this->dom->saveHTML($this->mainDiv);

        return trim(mb_eregi_replace('^<div>(.*)<\/div>$', '\1', $html));
    }

}