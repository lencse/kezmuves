<?php

namespace Lencse\Blog\Component\Content\Loader;


class PostDom
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
    private $title;

    /**
     * @var string
     */
    private $metaYaml;

    /**
     * @var string
     */
    private $featuredImage;

    /**
     * @param $html
     */
    function __construct($html)
    {
        $this->dom = new \DOMDocument();
        $this->dom->loadHTML('<?xml encoding="utf-8" ?><div>' . $html . '</div>');
        $this->mainDiv = $this->dom->getElementsByTagName('div')->item(0);

        $titleNode = $this->dom->getElementsByTagName('h1')->item(0);
        $this->mainDiv->removeChild($titleNode);
        $this->title = $titleNode->nodeValue;

        $firstImgNode = $this->dom->getElementsByTagName('img')->item(0);
        if ($firstImgNode && $firstImgNode->hasAttribute('class') && strstr($firstImgNode->getAttribute('class'), 'featured')) {
            $this->featuredImage = $firstImgNode->getAttribute('src');
            $firstImgNode->parentNode->removeChild($firstImgNode);
        }

        $xpath = new \DOMXPath($this->dom);
        $commentNode = $xpath->query('//comment()')->item(0);
        $commentNode->parentNode->removeChild($commentNode);
        $this->metaYaml = trim($commentNode->nodeValue);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
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

    /**
     * @return string
     */
    public function getFeaturedImage()
    {
        return $this->featuredImage;
    }

}