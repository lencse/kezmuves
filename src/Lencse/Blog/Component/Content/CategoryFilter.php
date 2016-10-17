<?php

namespace Lencse\Blog\Component\Content;


class CategoryFilter implements PostFilter
{

    /**
     * @var string
     */
    private $category;

    /**
     * @param string $category
     */
    public function __construct($category)
    {
        $this->category = $category;
    }

    /**
     * @param Post $post
     * @return bool
     */
    public function isFit(Post $post)
    {
        return $this->category == $post->getCategory();
    }

}
