<?php

namespace Lencse\Blog\Component\Content\Loader;


use Lencse\Blog\Component\Content\PostCollection;

class PostLoader
{

    /**
     * @var PostCollection
     */
    private $posts;

    /**
     * @param FileParser $parser
     * @param $path string
     */
    public function __construct(FileParser $parser, $path)
    {
        $this->posts = new PostCollection();
        $separator = '\\' . DIRECTORY_SEPARATOR;
        if (!file_exists($path)) {
            return;
        }
        $iterator = new \FilesystemIterator($path);
        $postFiles = new \RegexIterator($iterator, '|' . $separator . 'post-[^' . $separator . ']*\.md$|');
        foreach ($postFiles as $file) {
            $this->posts->addPost($parser->parse($file));
        }
    }

    /**
     * @return PostCollection
     */
    public function loadPosts()
    {
        return $this->posts;
    }

}