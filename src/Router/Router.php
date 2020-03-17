<?php

namespace Framework\Router;

use Framework\Contracts\RouterInterface;
use Framework\Exceptions\BadRouteConfigException;
use Framework\Exceptions\RouteNotFoundException;
use Framework\Http\Request;
use Framework\Routing\RouteMatch;

class Router implements RouterInterface
{

    const CONFIG_KEY_PATH = 'path';
    const CONFIG_KEY_METHOD = 'method';
    const CONFIG_KEY_CONTROLLER = 'controllerName';
    const CONFIG_KEY_ACTION = 'actionName';
    /**
     * @var array
     */
    private $routerConfig;

    /**
     * Router constructor.
     * @param array $routerConfig
     */
    public function __construct(array $routerConfig)
    {
        $this->routerConfig = $routerConfig;
    }

    /**
     * @param Request $request
     * @return RouteMatch
     * @throws BadRouteConfigException
     * @throws RouteNotFoundException
     */
    public function route(Request $request): RouteMatch
    {
        foreach ($this->routerConfig['routes'] as $routeName => $routeConfig) {

            if (!$this->validateRoute($routeConfig)) {
                throw new BadRouteConfigException($routeName, $routeConfig);
            }

            preg_match($this->createPath($routeConfig[self::CONFIG_KEY_PATH]), $request->getUri()->getPath(), $matches);

            if ($matches && $routeConfig[self::CONFIG_KEY_METHOD] === $request->getMethod()) {
                return new RouteMatch(
                    $request->getMethod(),
                    $routeConfig[self::CONFIG_KEY_CONTROLLER],
                    $routeConfig[self::CONFIG_KEY_ACTION],
                    $this->createRequestAttributes($this->createPath($routeConfig[self::CONFIG_KEY_PATH]), $request)
                );
            }
        }
        throw new RouteNotFoundException($request->getUri()->getPath());
    }

    /**
     * Constructs the path as a regex
     * @param string $path
     * @return string
     */
    public function createPath(string $path)
    {
        return '/^' . str_replace('/', '\/', $path) . '$/';
    }

    /**
     * Creates an array with the request attributes
     * @param string $path
     * @param Request $request
     * @return array
     */
    public function createRequestAttributes(string $path, Request $request): array
    {
        preg_match($path, $request->getUri()->getPath(), $matches);
        $requestAttributes = Array();
        foreach ($matches as $key => $value) {
            if (is_string($key)) {
                $requestAttributes[$key] = $value;
            }
        }
        foreach ($request->getParameters() as $key => $value) {
            $requestAttributes[$key] = $value;
        }

        return $requestAttributes;
    }

    /**
     * Verifies if a Route has all arguments
     * @param array $routeConfig
     * @return bool
     */
    private function validateRoute(array $routeConfig): bool
    {
        return array_key_exists(self::CONFIG_KEY_METHOD, $routeConfig) &&
            array_key_exists(self::CONFIG_KEY_CONTROLLER, $routeConfig) &&
            array_key_exists(self::CONFIG_KEY_ACTION, $routeConfig) &&
            array_key_exists(self::CONFIG_KEY_PATH, $routeConfig);
    }

}