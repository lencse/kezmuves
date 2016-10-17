<?php

namespace Lencse\Blog\Component\Content;


class Post
{

    const MORE_STRING = '<!-- MORE -->';

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $body;

    /**
     * @var \DateTime
     */
    private $publicationDate;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $featuredImage;

    /**
     * @var string[]
     */
    private $tags = [];

    /**
     * @var string
     */
    private $category;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return self
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getPublicationDate()
    {
        return $this->publicationDate;
    }

    /**
     * @param \DateTime $publicationDate
     * @return self
     */
    public function setPublicationDate(\DateTime $publicationDate)
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return self
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getPublicationDateInUrl()
    {
        return $this->getPublicationDate()->format('Y/m/d');
    }

    /**
     * @return bool
     */
    public function hasLead()
    {
        return strpos($this->getBody(), self::MORE_STRING) !== false;
    }

    /**
     * @return string
     */
    public function getLead()
    {
        if (!$this->hasLead()) {
            return $this->getBody();
        }
        $parts = explode(self::MORE_STRING, $this->getBody());

        return $parts[0];
    }

    /**
     * @param string $tag
     * @return $this
     */
    public function addTag($tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param $category
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string
     */
    public function getFeaturedImage()
    {
        return $this->featuredImage;
    }

    /**
     * @param string $featuredImage
     * @return $this
     */
    public function setFeaturedImage($featuredImage)
    {
        $this->featuredImage = $featuredImage;

        return $this;
    }

    /**
     * @return bool
     */
    public function isPublished()
    {
        $current = new \DateTime();

        return ($current->getTimestamp() - $this->getPublicationDate()->getTimestamp()) > 0;
    }

}
