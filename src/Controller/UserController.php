<?php


namespace Framework\Controller;


use Framework\Http\Request;
use Framework\Http\Response;

class UserController extends AbstractController
{
    public function add2(Request $request, array $requestAttributes): Response
    {
        return $this->renderer->renderJson($requestAttributes);
        //TODO define test.phtml & get params from reqA
        //return $this->renderer->renderView('test.phtml', ['id' => 1]);
    }

}