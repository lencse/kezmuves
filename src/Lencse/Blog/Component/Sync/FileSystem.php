<?php

namespace Lencse\Blog\Component\Sync;


interface FileSystem
{

    public function rmDir($dir);

    public function mkDir($dir);

}