<?php

namespace Lencse\Blog\Component\Test\Content\Loader;


use Lencse\Blog\Component\Content\Loader\PageDom;
use Lencse\Test\TestCase;

class PageDomTest extends TestCase
{

    const TEST_HTML = <<<EOS
<!--
slug: page1
title: Ez itt a cím
position: 3
-->
<h1>Test 1</h1>
<p>Paragraph 1</p>
<p>Paragraph 2</p>
EOS;

    const TEST_META = <<<EOM
slug: page1
title: Ez itt a cím
position: 3
EOM;

    /**
     * @var PostDom
     */
    private $dom;

    protected function setUp()
    {
        $this->dom = new PageDom(self::TEST_HTML);
    }

    public function testExtractMetaYaml()
    {
        $this->assertEquals(self::TEST_META, $this->dom->getMetaYaml());
    }

    public function testHtml()
    {
        $this->assertTrue(strpos($this->dom->getHtml(), '<h1>Test 1</h1>') !== false);
        $this->assertTrue(strpos($this->dom->getHtml(), '<p>Paragraph 1</p>') !== false);
        $this->assertTrue(strpos($this->dom->getHtml(), '<p>Paragraph 2</p>') !== false);
    }

    public function testHtmlForUtf8()
    {
        $specialChars = '<p>' . mb_convert_encoding('ÁRVÍZTŰRŐ TÜKÖRFÚRÓGÉP ?', 'UTF-8') .'</p>';
        $dom = new PageDom(self::TEST_HTML . $specialChars);
        $this->assertTrue(mb_strpos($dom->getHtml(), $specialChars) !== false);
    }

}