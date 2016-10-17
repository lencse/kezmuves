<?php

class GruntBuildTest extends PHPUnit_Framework_TestCase
{

    public function testBuild()
    {
        $files = [
            'assets/blur.svg',
            'assets/zocial/css/zocial-regular-webfont.ttf',
            'bower_components/sass-bootstrap/fonts/glyphicons-halflings-regular.eot',
            'images/author/lokilevente.jpg',
            'js/main.js',
            'stylesheets/main.css',
        ];
        foreach ($files as $file) {
            $this->assertFileExists(__DIR__ . '/../web/readable-theme/' . $file);
        }
    }

}
