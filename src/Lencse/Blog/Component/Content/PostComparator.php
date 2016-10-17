<?php

namespace Lencse\Blog\Component\Content;


interface PostComparator
{

    /**
     * @param Post $post1
     * @param Post $post2
     * @return int
     */
    public function compare(Post $post1, Post $post2);

}
