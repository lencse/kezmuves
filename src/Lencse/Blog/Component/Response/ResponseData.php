<?php

namespace Lencse\Blog\Component\Response;


use Lencse\Blog\Component\Content\Meta;
use Lencse\Blog\Component\Content\Page;
use Lencse\Blog\Component\Content\PageCollection;
use Lencse\Blog\Component\Content\Post;
use Lencse\Blog\Component\Content\PostCollection;

class ResponseData
{

    /**
     * @var PostCollection
     */
    private $postList;

    /**
     * @var PageCollection
     */
    private $pages;

    /**
     * @var PostCollection
     */
    private $allPosts;

    /**
     * @var string[]
     */
    private $categories;

    /**
     * @var string[]
     */
    private $tags;

    /**
     * @var string
     */
    private $tag;

    /**
     * @var string
     */
    private $category;

    /**
     * @var Post
     */
    private $post;

    /**
     * @var Page
     */
    private $page;

    /**
     * @var Meta
     */
    private $meta;

    /**
     * @var string
     */
    private $controllerAction;

    /**
     * @param PostCollection $postList
     */
    public function setPostList(PostCollection $postList)
    {
        $this->postList = new PostCollection();
        foreach ($postList as $post) {
            $this->postList->addPost($post);
        }

        return $this;
    }

    /**
     * @return PostCollection
     */
    public function getPostList()
    {
        return $this->postList;
    }

    /**
     * @param PostCollection $allPosts
     * @return $this
     */
    public function setAllPosts(PostCollection $allPosts)
    {
        $this->allPosts = new PostCollection();
        foreach ($allPosts as $post) {
            $this->allPosts->addPost($post);
        }

        return $this;
    }

    /**
     * @return PostCollection
     */
    public function getAllPosts()
    {
        return $this->allPosts;
    }

    /**
     * @param PageCollection $pages
     * @return $this
     */
    public function setPages(PageCollection $pages)
    {
        $this->pages = new PageCollection();
        foreach ($pages as $page) {
            $this->pages->addPage($page);
        }

        return $this;
    }

    /**
     * @return PageCollection
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * @return \string[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param \string[] $categories
     * @return ResponseData
     */
    public function setCategories(array $categories)
    {
        $this->categories = $categories;

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
     * @param \string[] $tags
     * @return ResponseData
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * @param string $tag
     * @return ResponseData
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     * @return ResponseData
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param Post $post
     * @return ResponseData
     */
    public function setPost($post)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @return Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param Page $page
     * @return ResponseData
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * @return Meta
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param Meta $meta
     * @return ResponseData
     */
    public function setMeta($meta)
    {
        $this->meta = $meta;
        return $this;
    }

    /**
     * @return string
     */
    public function getControllerAction()
    {
        return $this->controllerAction;
    }

    /**
     * @param string $controllerAction
     * @return ResponseData
     */
    public function setControllerAction($controllerAction)
    {
        $this->controllerAction = $controllerAction;
        return $this;
    }
    
}