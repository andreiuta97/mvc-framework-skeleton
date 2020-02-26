<?php

namespace Framework\Router;

use Framework\Contracts\RouterInterface;
use Framework\Http\Request;
use Framework\Routing\RouteMatch;

class Router implements RouterInterface
{

    private $routesConfig;

    public function __construct(array $routesConfig)
    {
        $this->routesConfig = $routesConfig;
    }

    public function route(Request $request): RouteMatch
    {
        foreach ($this->routesConfig as $key => $value) {
            preg_match($this->createPath($value['path']), $request->getPath(), $matches);
            if ($matches && $value['method'] === $request->getMethod()){
                return new RouteMatch(
                    $request->getMethod(),
                    $value['controllerName'],
                    $value['actionName'],
                    $this->createRequestAttributes($this->createPath($value['path']),  $request->getPath())
                );
            }
        }
    }

    public function createPath(string $path)
    {
        return '/^' . str_replace('/', '\/', $path) . '$/';
    }

    public function createRequestAttributes(string $path, string $request): array
    {


        preg_match($path, $request, $matches);
        $requestAttributes = Array();
        foreach ($matches as $key => $value) {
            if(!is_numeric($key)) {
                $requestAttributes[$key] = $value;
            }
        }
        return $requestAttributes;

    }

}