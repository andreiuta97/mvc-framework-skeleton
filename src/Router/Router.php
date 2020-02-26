<?php

namespace Framework\Router;

use Framework\Contracts\RouterInterface;
use Framework\Exceptions\BadRouteConfigException;
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

    public function __construct(array $routerConfig)
    {
        $this->routerConfig = $routerConfig;
    }

    /**
     * @param Request $request
     * @return RouteMatch
     * @throws BadRouteConfigException
     */
    public function route(Request $request): RouteMatch
    {
        foreach ($this->routerConfig['routes'] as $routeName => $routeConfig) {

            if (!$this->validateRoute($routeConfig)) {
                throw new BadRouteConfigException($routeName, $routeConfig);
            }

            preg_match($this->createPath($routeConfig[self::CONFIG_KEY_PATH]), $request->getPath(), $matches);
            if ($matches && $routeConfig[self::CONFIG_KEY_METHOD] === $request->getMethod()) {
                return new RouteMatch(
                    $request->getMethod(),
                    $this->getControllerName($routeConfig[self::CONFIG_KEY_CONTROLLER]),
                    $routeConfig[self::CONFIG_KEY_ACTION],
                    $this->createRequestAttributes($this->createPath($routeConfig[self::CONFIG_KEY_PATH]), $request->getPath())
                );
            }
        }
    }

    public function createPath(string $path)
    {
        /*$var = Array();
        $var = explode('/\//', $path);
        foreach ($var as $value) {
            if(is_numeric($value)) {
                $value = '(?<id>\d+)';
            }
            if($value == 'ADMIN' || $value == 'GUEST') {
                $value = '(?<role>(ADMIN|GUEST))';
            }
            return $var;
        }
        print_r($var);*/
        return '/^' . str_replace('/', '\/', $path) . '$/';
    }

    public function createRequestAttributes(string $path, string $request): array
    {
        preg_match($path, $request, $matches);
        $requestAttributes = Array();
        foreach ($matches as $key => $value) {
            if (is_string($key)) {
                $requestAttributes[$key] = $value;
            }
        }

        return $requestAttributes;
    }

    private function getControllerName(string $controllerName): string
    {
        $namespace = $this->routerConfig['controller_namespace'] . '\\';
        $suffix = $this->routerConfig['controller_suffix'];

        return $namespace . ucfirst($controllerName) . $suffix;
    }

    private function validateRoute(array $routeConfig): bool
    {
        return array_key_exists(self::CONFIG_KEY_METHOD, $routeConfig) &&
            array_key_exists(self::CONFIG_KEY_CONTROLLER, $routeConfig) &&
            array_key_exists(self::CONFIG_KEY_ACTION, $routeConfig) &&
            array_key_exists(self::CONFIG_KEY_PATH, $routeConfig);
    }

}
