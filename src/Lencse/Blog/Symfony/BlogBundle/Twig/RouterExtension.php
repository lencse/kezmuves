<?php

namespace Lencse\Blog\Symfony\BlogBundle\Twig;


use Lencse\Blog\Symfony\BlogBundle\Routing\PostRouter;

class RouterExtension extends \Twig_Extension
{

    /**
     * @var PostRouter
     */
    private $postRouter;

    /**
     * @param PostRouter $postRouter
     */
    public function __construct(PostRouter $postRouter)
    {
        $this->postRouter = $postRouter;
    }

    /**
     * @return \Twig_SimpleFunction
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('postRoute', [$this->postRouter, 'generatePostUrl'])
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'lencse_post_router';
    }

}