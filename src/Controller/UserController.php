<?php

namespace Framework\Controller;

use Framework\Http\Request;
use Framework\Http\Response;

class UserController extends AbstractController
{
    /**
     * @param Request $request
     * @param array $requestAttributes
     * @return Response
     */
    public function get(Request $request, array $requestAttributes):Response
    {
        return $this->renderer->renderView('user.phtml', $requestAttributes);
    }

    /**
     * @param Request $request
     * @param array $requestAttributes
     * @return Response
     */
    public function post(Request $request, array $requestAttributes):Response
    {
        return $this->renderer->renderView('userPost.phtml', $requestAttributes);
    }

    /**
     * @param Request $request
     * @param array $requestAttributes
     * @return Response
     */
    public function delete(Request $request, array $requestAttributes):Response
    {
        return $this->renderer->renderJson($requestAttributes);
    }

    /**
     * @param Request $request
     * @param array $requestAttributes
     * @return Response
     */
    public function add2(Request $request, array $requestAttributes): Response
    {
        return $this->renderer->renderJson($requestAttributes);
    }

}