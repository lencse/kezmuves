<?php

namespace Lencse\Blog\Component\Controller;


use Lencse\Blog\Component\Response\ResponseData;

interface ResponseHandler
{

    /**
     * @param $view string
     * @param ResponseData $response
     * @return mixed
     */
    public function renderView($view, ResponseData $response);

    /**
     * @return mixed
     */
    public function notFoundResponse();

    /**
     * @param $route string
     * @param array $params
     * @return mixed
     */
    public function redirectResponse($route, array $params = []);

}