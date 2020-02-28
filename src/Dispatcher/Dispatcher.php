<?php
namespace Framework\Dispatcher;

use Framework\Contracts\DispatcherInterface;
use Framework\Controller\AbstractController;
use Framework\Routing\RouteMatch;
use Framework\Http\Request;
use Framework\Http\Response;

class Dispatcher implements DispatcherInterface
{
    private $controllerNamespace;
    private $controllerSuffix;
    private $controllers = [];

    public function __construct(array $config)
    {
        //TODO use constants for array keys
        $this->controllerNamespace = $config['controller_namespace'];
        $this->controllerSuffix = $config['controller_suffix'];
    }

    /**
     * @inheritDoc
     */
    public function dispatch(RouteMatch $routeMatch, Request $request): Response
    {
        // 1. nume controller pe route, namespace, suffix = FQN
        $FQCN = $this->controllerNamespace . '\\' . ucfirst($routeMatch->getControllerName()) . $this->controllerSuffix;
        // 2. Identifica controllerul
        $controller = $this->getController($FQCN);
        // 2. cheama o metoda din routeMatch
        $action = $routeMatch->getActionName();

        return $controller->$action($request, $routeMatch->getRequestAttributes());
    }

    public function addController(AbstractController $controller)
    {
        $this->controllers[] = $controller;
    }

    private function getFQCN(string $controllerName, string $controllerSuffix): string
    {
        return $controllerName . '\\' . ucfirst($controllerName) . $controllerSuffix;
    }

    private function getController(string $controllerName)
    {
        foreach($this->controllers as $controller) {
            if($controllerName === get_class($controller)) {
                return $controller;
            }
        }

        //Arunca exceptie
    }
}