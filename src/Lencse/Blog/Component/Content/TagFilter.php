<?php

namespace Lencse\Blog\Component\Content;


class TagFilter implements PostFilter
{

    /**
     * @var string
     */
    private $tag;

    /**
     * @param string $tag
     */
    public function __construct($tag)
    {
        $this->tag = $tag;
    }

    /**
     * @param Post $post
     * @return bool
     */
    public function isFit(Post $post)
    {
        return in_array($this->tag, $post->getTags());
    }

}
