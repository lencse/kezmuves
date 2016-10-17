<?php

namespace Lencse\Blog\Component\Sync;


class ContentDownloader
{

    /**
     * @var string
     */
    private $zipUrl;

    /**
     * @var string
     */
    private $contentDir;

    /**
     * @var string
     */
    private $assetDir;

    /**
     * @param $zipUrl
     * @param $contentDir
     * @param #assetDir
     */
    public function __construct($zipUrl, $contentDir, $assetDir)
    {
        $this->zipUrl = $zipUrl;
        if (!file_exists($contentDir)) {
            mkdir($contentDir);
        }
        $this->contentDir = realpath($contentDir);
        if (!file_exists($assetDir)) {
            mkdir($assetDir);
        }
        $this->assetDir = realpath($assetDir);
    }

    public function download()
    {
        $tmpDir = $this->downloadAndExtractDir();
        $this->cleanContentDir();
        $this->installContentFiles($tmpDir);
        $this->cleanAssetDir();
        $this->installAssetFiles($tmpDir);
    }

    /**
     * @return string
     */
    private function downloadAndExtractDir()
    {
        $zipFilePath = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid() . '.zip';
        $zipFileRes = fopen($zipFilePath, 'w');
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, false);
        curl_setopt($curl, CURLOPT_URL, $this->zipUrl);
        curl_setopt($curl, CURLOPT_HTTPGET, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_CAINFO, implode(DIRECTORY_SEPARATOR, [__DIR__, 'certificate', 'github.cer']));
        curl_setopt($curl, CURLOPT_FILE, $zipFileRes);
        curl_exec($curl);
        if (curl_errno($curl)) {
            throw new \RuntimeException(sprintf('cURL error #%d: %s', curl_errno($curl), curl_error($curl)));
        }
        curl_close($curl);
        fclose($zipFileRes);

        $zip = new \ZipArchive();
        $zip->open($zipFilePath);
        $tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . uniqid();
        $zip->extractTo($tmpDir);
        return $tmpDir;
    }

    private function cleanContentDir()
    {
        $iterator = new \RecursiveDirectoryIterator($this->contentDir, \RecursiveDirectoryIterator::SKIP_DOTS);
        foreach (new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST) as $file) {
            /** @var \SplFileInfo $file */
            if ($file->getRealPath() == $this->contentDir . DIRECTORY_SEPARATOR . '.gitkeep') {
                continue;
            }
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
    }

    /**
     * @param $tmpDir
     */
    private function installContentFiles($tmpDir)
    {
        foreach (glob($tmpDir . '/*/*') as $contentFiles) {
            $file = new \SplFileInfo($contentFiles);
            if ($file->isDir()) {
                continue;
            }
            rename($file->getRealPath(), $this->contentDir . DIRECTORY_SEPARATOR . $file->getFilename());
        }
    }

    private function cleanAssetDir()
    {
        $iterator = new \RecursiveDirectoryIterator($this->assetDir, \RecursiveDirectoryIterator::SKIP_DOTS);
        foreach (new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST) as $file) {
            /** @var \SplFileInfo $file */
            if ($file->getRealPath() == $this->assetDir . DIRECTORY_SEPARATOR . '.gitkeep') {
                continue;
            }
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
    }

    /**
     * @param $tmpDir
     */
    private function installAssetFiles($tmpDir)
    {
        $assetRoot = realpath(glob($tmpDir . '/*/content')[0]);
        $iterator = new \RecursiveDirectoryIterator($assetRoot, \RecursiveDirectoryIterator::SKIP_DOTS);
        foreach (new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::SELF_FIRST) as $file) {
            /** @var \SplFileInfo $file */
            $newPath = preg_replace('|^' . str_replace('\\', '\\\\', $assetRoot) . '|', $this->assetDir, $file->getRealPath());
            if ($file->isDir()) {
                mkdir($newPath);
            } else {
                copy($file->getRealPath(), $newPath);
            }
        }
    }

}