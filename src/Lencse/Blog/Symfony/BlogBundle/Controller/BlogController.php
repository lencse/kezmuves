<?php

namespace Lencse\Blog\Symfony\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class BlogController extends Controller
{

    /**
     * @Route("/", name="lencse_blog_post_list")
     */
    public function indexAction()
    {
        return $this->getController()->postList();
    }

    /**
     * @Route("/{date}/{slug}", name="lencse_blog_post_show", requirements={"date"="\d{4}/\d{2}/\d{2}"})
     * @param $date string
     * @param $slug string
     * @return mixed
     */
    public function showPostAction($date, $slug)
    {
        return $this->getController()->showPost($date, $slug);
    }

    /**
     * @Route("/tag/{tag}", name="lencse_blog_tag")
     * @param $tag string
     */
    public function listByTagAction($tag)
    {
        return $this->getController()->listByTag($tag);
    }

    /**
     * @Route("/category/{category}", name="lencse_blog_category")
     * @param $category string
     */
    public function listByCategoryAction($category)
    {
        return $this->getController()->listByCategory($category);
    }

    /**
     * @Route("/categories", name="lencse_blog_category_list")
     */
    public function categoryListAction()
    {
        return $this->getController()->categoryList();
    }

    /**
     * @Route("/tags", name="lencse_blog_tag_list")
     */
    public function tagListAction()
    {
        return $this->getController()->tagList();
    }

    /**
     * @Route("/{slug}", name="lencse_blog_page_show")
     * @param $slug string
     * @return mixed
     */
    public function showPageAction($slug)
    {
        return $this->getController()->showPage($slug);
    }

    /**
     * @return \Lencse\Blog\Component\Controller\Controller
     */
    private function getController()
    {
        return $this->get('lencse.blog.controller');
    }

}
