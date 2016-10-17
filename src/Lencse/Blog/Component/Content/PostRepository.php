<?php

namespace Lencse\Blog\Component\Content;


class PostRepository
{

    /**
     * @var PostCollection
     */
    private $allPosts;

    /**
     * @param PostCollection $allPosts
     */
    public function __construct(PostCollection $allPosts)
    {
        $this->allPosts = $allPosts;
    }

    /**
     * @return PostCollection
     */
    public function getAllOrderByDate()
    {
        return $this->getAll()->orderBy(new DateComparator());
    }

    /**
     * @param string $category
     * @return PostCollection
     */
    public function getByCategoryOrderByDate($category)
    {
        return $this->getAll()->filter(new CategoryFilter($category))->orderBy(new DateComparator());
    }

    /**
     * @param string $tag
     * @return PostCollection
     */
    public function getByTagOrderByDate($tag)
    {
        return $this->getAll()->filter(new TagFilter($tag))->orderBy(new DateComparator());
    }

    /**
     * @return string[]
     */
    public function getCategories()
    {
        $categories = [];
        foreach ($this->getAll() as $post) {
            $categories[] = $post->getCategory();
        }

        return array_unique($categories);
    }

    /**
     * @return string[]
     */
    public function getTags()
    {
        $tags = [];
        foreach ($this->getAll() as $post) {
            $tags = array_merge($tags, $post->getTags());
        }

        return array_unique($tags);
    }

    /**
     * @return PostCollection
     */
    private function getAll()
    {
        return $this->allPosts->filter(new PublishedFilter());
    }

    /**
     * @param string $slug
     * @return Post
     */
    public function getPostBySlug($slug)
    {
        return $this->allPosts->getPostBySlug($slug);
    }

    /**
     * @param string $slug
     * @return bool
     */
    public function hasPostWithSlug($slug)
    {
        return $this->allPosts->hasPostWithSlug($slug);
    }

}