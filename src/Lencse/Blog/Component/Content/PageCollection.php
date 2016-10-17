<?php

namespace Lencse\Blog\Component\Content;


class PageCollection implements \Iterator
{

    /**
     * @var Page[]
     */
    private $bySlug = [];

    /**
     * @var Page[]
     */
    private $ordered = [];

    /**
     * @var int
     */
    private $currentPosition = 0;

    /**
     * @param Page $page
     */
    public function addPage(Page $page)
    {
        if ($this->hasPageWithSlug($page->getSlug())) {
            throw new \InvalidArgumentException(sprintf('Duplicate slug: %s', $page->getSlug()));
        }
        $this->bySlug[$page->getSlug()] = $page;
        $this->ordered[] = $page;
        usort($this->ordered, [$this, 'compareByPosition']);
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     * @param Page $page1
     * @param Page $page2
     * @return int
     */
    private function compareByPosition(Page $page1, Page $page2)
    {
        return $page1->getPosition() - $page2->getPosition();
    }

    /**
     * @param string $slug
     * @return Page
     */
    public function getPageBySlug($slug)
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
    public function hasPageWithSlug($slug)
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

    // Methods for Iterator interface

    /**
     * @return Page
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