<?php

namespace Lencse\Blog\Component\Test\Content\Loader;


use Lencse\Blog\Component\Content\Loader\PostDom;
use Lencse\Test\TestCase;

class PostDomTest extends TestCase
{

    const TEST_HTML = <<<EOS
<!--
slug: first-test-post-1
-->
<img src="dummy/image.jpg" alt="dummy" class="featured"/>
<h1>Test 1</h1>
<p>Paragraph 1</p>
<!-- MORE -->
<p>Paragraph 2</p>
EOS;

    const TEST_META = <<<EOM
slug: first-test-post-1
EOM;

    /**
     * @var PostDom
     */
    private $dom;

    protected function setUp()
    {
        $this->dom = new PostDom(self::TEST_HTML);
    }

    public function testExtractTitle()
    {
        $this->assertEquals('Test 1', $this->dom->getTitle());
    }

    public function testExtractMetaYaml()
    {
        $this->assertEquals(self::TEST_META, $this->dom->getMetaYaml());
    }

    public function testHtml()
    {
        $this->assertTrue(strpos($this->dom->getHtml(), '<h1>') === false);
        $this->assertTrue(strpos($this->dom->getHtml(), '<p>Paragraph 1</p>') !== false);
        $this->assertTrue(strpos($this->dom->getHtml(), '<!-- MORE -->') !== false);
        $this->assertTrue(strpos($this->dom->getHtml(), '<p>Paragraph 2</p>') !== false);
    }

    public function testHtmlForUtf8()
    {
        $specialChars = '<p>' . mb_convert_encoding('ÁRVÍZTŰRŐ TÜKÖRFÚRÓGÉP ?', 'UTF-8') .'</p>';
        $dom = new PostDom(self::TEST_HTML . $specialChars);
        $this->assertTrue(mb_strpos($dom->getHtml(), $specialChars) !== false);
    }

    public function testFeaturedImage()
    {
       $this->assertEquals('dummy/image.jpg', $this->dom->getFeaturedImage());
    }

}