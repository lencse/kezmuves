<?php

namespace Lencse\Blog\Component\Content;


interface PostFilter
{

    /**
     * @param Post $post
     * @return bool
     */
    public function isFit(Post $post);

}
