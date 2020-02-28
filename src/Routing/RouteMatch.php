<?php

namespace Framework\Routing;

class RouteMatch
{

    /**
     * @var string
     */
    private $method;
    /**
     * @var string
     */
    private $controllerName;
    /**
     * @var string
     */
    private $actionName;
    /**
     * @var array
     */
    private $requestAttributes;

    /**
     * RouteMatch constructor.
     * @param string $method
     * @param string $controllerName
     * @param string $actionName
     * @param array $requestAttributes
     */
    public function __construct
    (
        string $method,
        string $controllerName,
        string $actionName,
        array $requestAttributes
    )
    {
        $this->method = $method;
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $this->requestAttributes = $requestAttributes;
    }

    /**
     * Returns the method from a RouteMatch
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Returns the controller name from a RouteMatch
     * @return string
     */
    public function getControllerName(): string
    {
        return $this->controllerName;
    }

    /**
     * Returns the action name from a RouteMatch
     * @return string
     */
    public function getActionName(): string
    {
        return $this->actionName;
    }

    /**
     * Returns the request attributes from a RouteMatch
     * @return array
     */
    public function getRequestAttributes(): array
    {
        return $this->requestAttributes;
    }
}
