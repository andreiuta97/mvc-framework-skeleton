<?php

namespace Framework\Contracts;

use Framework\Http\Request;
use Framework\Http\Response;
use Framework\Routing\RouteMatch;

interface DispatcherInterface
{
    /**
     * Obtains controller based on the RouteMatch and executes its logic/method passing the request.
     *
     * @param RouteMatch $routeMatch
     * @param Request $request
     *
     * @return Response
     */
    public function dispatch(RouteMatch $routeMatch, Request $request): Response;
}
