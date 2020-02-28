<?php

namespace Framework\Exceptions;

class RouteNotFoundException extends RouterException
{
    /**
     * @var array
     */
    private $route;

    public function __construct(string $route)
    {
        parent::__construct(sprintf('Route not found!'));
        $this->route = $route;
    }

    /**
     * @return array
     */
    public function getRoute(): string
    {
        return $this->route;
    }
}