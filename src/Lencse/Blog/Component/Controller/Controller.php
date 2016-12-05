<?php

namespace Lencse\Blog\Component\Controller;


use Lencse\Blog\Component\Content\Meta;
use Lencse\Blog\Component\Content\PageRepository;
use Lencse\Blog\Component\Content\PostRepository;
use Lencse\Blog\Component\Response\ResponseData;

class Controller
{

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var PageRepository
     */
    private $pageRepository;

    /**
     * @var ResponseHandler
     */
    private $responseHandler;

    /**
     * @param PostRepository $postRepository
     * @param PageRepository $pageRepository
     * @param ResponseHandler $responseHandler
     */
    public function __construct(PostRepository $postRepository, PageRepository $pageRepository, ResponseHandler $responseHandler)
    {
        $this->postRepository = $postRepository;
        $this->pageRepository = $pageRepository;
        $this->responseHandler = $responseHandler;
    }

    /**
     * @return mixed
     */
    public function postList()
    {
        $meta = new Meta();
        $meta->setTitle('Kézműves Programozó')
            ->setType('website')
            ->setDescription('Webfejlesztő, szoftvertervező, a nők barátja és a fogkő ellensége.');

        $response = new ResponseData();
        $response->setControllerAction(explode('::', __METHOD__)[1]);
        $response->setPostList($this->postRepository->getAllOrderByDate())
            ->setAllPosts($this->postRepository->getAllOrderByDate())
            ->setCategories($this->postRepository->getCategories())
            ->setTags($this->postRepository->getTags())
            ->setPages($this->pageRepository->getAll())
            ->setMeta($meta);

        return $this->responseHandler->renderView('postList', $response);
    }

    /**
     * @param $date string
     * @param $slug string
     * @return mixed
     */
    public function showPost($date, $slug)
    {
        if (!$this->postRepository->hasPostWithSlug($slug)) {
            return $this->responseHandler->notFoundResponse();
        }
        $post = $this->postRepository->getPostBySlug($slug);
        if ($date != $post->getPublicationDateInUrl()) {
            return $this->responseHandler->redirectResponse('lencse_blog_post_show', [
                'date' => $post->getPublicationDateInUrl(),
                'slug' => $post->getSlug(),
            ]);
        }
        $meta = new Meta();
        $meta->setTitle($post->getTitle())
            ->setType('article')
            ->setDescription(trim(strip_tags($post->getLead())))
            ->setImage($post->getFeaturedImage());

        $response = new ResponseData();
        $response->setControllerAction(explode('::', __METHOD__)[1]);
        $response->setAllPosts($this->postRepository->getAllOrderByDate())
            ->setCategories($this->postRepository->getCategories())
            ->setTags($this->postRepository->getTags())
            ->setPages($this->pageRepository->getAll())
            ->setPost($post)
            ->setMeta($meta);

        return $this->responseHandler->renderView('showPost', $response);
    }

    /**
     * @param $tag string
     * @return mixed
     */
    public function listByTag($tag)
    {
        if (!in_array($tag, $this->postRepository->getTags())) {
            return $this->responseHandler->notFoundResponse();
        }
        $meta = new Meta();
        $meta->setTitle($tag)
            ->setType('website')
            ->setDescription(sprintf('%s – Kézműves Programozó', $tag));

        $response = new ResponseData();
        $response->setControllerAction(explode('::', __METHOD__)[1]);
        $response->setPostList($this->postRepository->getByTagOrderByDate($tag))
            ->setAllPosts($this->postRepository->getAllOrderByDate())
            ->setCategories($this->postRepository->getCategories())
            ->setTags($this->postRepository->getTags())
            ->setPages($this->pageRepository->getAll())
            ->setTag($tag)
            ->setMeta($meta);

        return $this->responseHandler->renderView('tag', $response);
    }

    /**
     * @param $category
     * @return mixed
     */
    public function listByCategory($category)
    {
        if (!in_array($category, $this->postRepository->getCategories())) {
            return $this->responseHandler->notFoundResponse();
        }
        $meta = new Meta();
        $meta->setTitle($category)
            ->setType('website')
            ->setDescription(sprintf('%s – Kézműves Programozó', $category));

        $response = new ResponseData();
        $response->setControllerAction(explode('::', __METHOD__)[1]);
        $response->setPostList($this->postRepository->getByCategoryOrderByDate($category))
            ->setAllPosts($this->postRepository->getAllOrderByDate())
            ->setCategories($this->postRepository->getCategories())
            ->setTags($this->postRepository->getTags())
            ->setPages($this->pageRepository->getAll())
            ->setCategory($category)
            ->setMeta($meta);

        return $this->responseHandler->renderView('category', $response);
    }

    /**
     * @param $slug string
     * @return mixed
     */
    public function showPage($slug)
    {
        if (!$this->pageRepository->hasPageWithSlug($slug)) {
            $this->responseHandler->notFoundResponse();
        }
        $response = new ResponseData();
        $response->setControllerAction(explode('::', __METHOD__)[1]);
        $page = $this->pageRepository->getPageBySlug($slug);
        $meta = new Meta();
        $meta->setTitle($page->getTitle())
            ->setType('article')
            ->setDescription(strip_tags($page->getBody()));

        $response->setAllPosts($this->postRepository->getAllOrderByDate())
            ->setCategories($this->postRepository->getCategories())
            ->setTags($this->postRepository->getTags())
            ->setPages($this->pageRepository->getAll())
            ->setPage($page)
            ->setMeta($meta);

        return $this->responseHandler->renderView('showPage', $response);
    }

    /**
     * @return mixed
     */
    public function categoryList()
    {

$response = new ResponseData();
$response->setControllerAction(explode('::', __METHOD__)[1]);
$meta = new Meta();
$meta->setTitle('Kézműves Programozó')
    ->setType('website')
    ->setDescription('Kategóriák');

$response->setAllPosts($this->postRepository->getAllOrderByDate())
    ->setCategories($this->postRepository->getCategories())
    ->setTags($this->postRepository->getTags())
    ->setPages($this->pageRepository->getAll())
    ->setMeta($meta);

return $this->responseHandler->renderView('categoryList', $response);
    }
    /**
     * @return mixed
     */
    public function tagList()
    {
        $response = new ResponseData();
        $response->setControllerAction(explode('::', __METHOD__)[1]);
        $meta = new Meta();
        $meta->setTitle('Kézműves Programozó')
            ->setType('website')
            ->setDescription('Címkék');

        $response->setAllPosts($this->postRepository->getAllOrderByDate())
            ->setCategories($this->postRepository->getCategories())
            ->setTags($this->postRepository->getTags())
            ->setPages($this->pageRepository->getAll())
            ->setMeta($meta);

        return $this->responseHandler->renderView('tagList', $response);
    }

}