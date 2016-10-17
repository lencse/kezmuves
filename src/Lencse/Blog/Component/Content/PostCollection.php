<?php

namespace Lencse\Blog\Component\Content;


class PostCollection implements \Iterator
{

    /**
     * @var Post[]
     */
    private $bySlug = [];

    /**
     * @var Post[]
     */
    private $ordered = [];

    /**
     * @var int
     */
    private $currentPosition = 0;

    /**
     * @param Post $post
     */
    public function addPost(Post $post)
    {
        if ($this->hasPostWithSlug($post->getSlug())) {
            throw new \InvalidArgumentException(sprintf('Duplicate slug: %s', $post->getSlug()));
        }
        $this->bySlug[$post->getSlug()] = $post;
        $this->ordered[] = $post;
    }

    /**
     * @param string $slug
     * @return Post
     */
    public function getPostBySlug($slug)
    {
        if (!array_key_exists($slug, $this->bySlug)) {
            throw new \InvalidArgumentException(sprintf('Invalid slug: %s', $slug));
        }

        return $this->bySlug[$slug];
    }

    /**
     * @param string $slug
     * @return bool
     */
    public function hasPostWithSlug($slug)
    {
        return array_key_exists($slug, $this->bySlug);
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return count($this->ordered);
    }

    /**
     * @param PostFilter $filter
     * @return PostCollection
     */
    public function filter(PostFilter $filter)
    {
        $ret = new PostCollection();
        foreach ($this->ordered as $post) {
            if ($filter->isFit($post)) {
                $ret->addPost($post);
            }
        }

        return $ret;
    }

    /**
     * @param PostComparator $comparator
     * @return PostCollection
     */
    public function orderBy(PostComparator $comparator)
    {
        $ret = new PostCollection();
        $newArray = $this->ordered;
        usort($newArray, [$comparator, 'compare']);
        foreach ($newArray as $post) {
            $ret->addPost($post);
        }

        return $ret;
    }

    // Methods for Iterator interface

    /**
     * @return Post
     */
    public function current()
    {
        return $this->ordered[$this->currentPosition];
    }

    public function next()
    {
        ++$this->currentPosition;
    }

    /**
     * @return int
     */
    public function key()
    {
        return $this->currentPosition;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return isset($this->ordered[$this->currentPosition]);
    }

    public function rewind()
    {
        $this->currentPosition = 0;
    }

}