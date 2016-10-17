<?php

namespace Lencse\Blog\Component\Content;


class PageRepository
{

    /**
     * @var PageCollection
     */
    private $pages;

    /**
     * @param PageCollection $pages
     */
    public function __construct(PageCollection $pages)
    {
        $this->pages = $pages;
    }

    /**
     * @return PostCollection
     */
    public function getAll()
    {
        return $this->pages;
    }

    /**
     * @param string $slug
     * @return Page
     */
    public function getPageBySlug($slug)
    {
        return $this->pages->getPageBySlug($slug);
    }

    /**
     * @param string $slug
     * @return bool
     */
    public function hasPageWithSlug($slug)
    {
        return $this->pages->hasPageWithSlug($slug);
    }

}