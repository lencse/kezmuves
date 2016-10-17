<?php

namespace Lencse\Blog\Symfony\BlogBundle\Routing;


use Lencse\Blog\Component\Content\Post;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PostRouter
{

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * @param UrlGeneratorInterface $router
     */
    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param Post $post
     * @return string
     */
    public function generatePostUrl(Post $post)
    {
        return $this->router->generate(
            'lencse_blog_post_show', [
                'date' => $post->getPublicationDateInUrl(),
                'slug' => $post->getSlug()
            ]
        );
    }

}