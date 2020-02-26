<?php
namespace Framework\Exceptions;

class BadRouteConfigException extends RouterException
{
    /**
     * @var array
     */
    private $routeConfig;

    public function __construct(string $routeName, array $routeConfig)
    {
        parent::__construct(sprintf('Config for route %s is bad', $routeName));
        $this->routeConfig = $routeConfig;
    }

    /**
     * @return array
     */
    public function getRouteConfig(): array
    {
        return $this->routeConfig;
    }
}
