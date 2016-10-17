<?php

namespace Lencse\Blog\Component\Content;


class DateComparator implements PostComparator
{

    /**
     * @param Post $post1
     * @param Post $post2
     * @return int
     */
    public function compare(Post $post1, Post $post2)
    {
        return $post2->getPublicationDate()->getTimestamp() - $post1->getPublicationDate()->getTimestamp();
    }

}