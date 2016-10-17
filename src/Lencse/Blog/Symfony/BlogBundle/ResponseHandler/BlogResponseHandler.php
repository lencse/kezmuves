<?php

namespace Lencse\Blog\Symfony\BlogBundle\ResponseHandler;


use Lencse\Blog\Component\Controller\ResponseHandler;
use Lencse\Blog\Component\Response\ResponseData;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class BlogResponseHandler implements ResponseHandler
{

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    /**
     * @param EngineInterface $templating
     * @param UrlGeneratorInterface $router
     */
    public function __construct(EngineInterface $templating, UrlGeneratorInterface $router)
    {
        $this->templating = $templating;
        $this->router = $router;
    }

    /**
     * @param $view string
     * @param ResponseData $response
     * @return mixed
     */
    public function renderView($view, ResponseData $response)
    {
        return $this->templating->renderResponse("BlogBundle:Blog:$view.html.twig", ['data' => $response]);
    }

    public function notFoundResponse()
    {
        throw new NotFoundHttpException('Page not found');
    }

    public function redirectResponse($route, array $params = [])
    {
        return new RedirectResponse($this->router->generate($route, $params));
    }


}