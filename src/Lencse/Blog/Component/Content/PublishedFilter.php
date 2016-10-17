<?php

namespace Lencse\Blog\Component\Content;


class PublishedFilter implements PostFilter
{

    /**
     * @param Post $post
     * @return bool
     */
    public function isFit(Post $post)
    {
        return $post->isPublished();
    }

}