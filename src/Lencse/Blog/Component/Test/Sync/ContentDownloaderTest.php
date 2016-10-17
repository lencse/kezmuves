<?php

namespace Lencse\Blog\Component\Test\Sync;


use Lencse\Blog\Component\Sync\ContentDownloader;
use Lencse\Test\TestCase;

class ContentDownloaderTest extends TestCase
{

    /**
     * @group expensive
     */
    public function testSynchronize()
    {
        $zipUrl = 'https://github.com/lencse/ll-blog-content/archive/master.zip';
        $contentDir = sys_get_temp_dir() . '/ll-content';
        $assetDir = sys_get_temp_dir() . '/ll-asset';
        $synchronizer = new ContentDownloader($zipUrl, $contentDir, $assetDir);
        $synchronizer->download();
        $this->assertNotEmpty(glob($contentDir));
        $this->assertFileExists($assetDir. '/img');
    }

}