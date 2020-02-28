<?php

namespace Framework\Dispatcher;

use Framework\Contracts\DispatcherInterface;
use Framework\Controller\AbstractController;
use Framework\Routing\RouteMatch;
use Framework\Http\Request;
use Framework\Http\Response;

class Dispatcher implements DispatcherInterface
{
    const CONFIG_CONTROLLER_NAMESPACE = 'controller_namespace';
    const CONFIG_CONTROLLER_SUFFIX = 'controller_suffix';

    /**
     * @var mixed
     */
    private $controllerNamespace;
    /**
     * @var mixed
     */
    private $controllerSuffix;
    /**
     * @var array
     */
    private $controllers = [];

    /**
     * Dispatcher constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->controllerNamespace = $config[self::CONFIG_CONTROLLER_NAMESPACE];
        $this->controllerSuffix = $config[self::CONFIG_CONTROLLER_SUFFIX];
    }

    /**
     * @inheritDoc
     */
    public function dispatch(RouteMatch $routeMatch, Request $request): Response
    {
        $FQCN = $this->controllerNamespace . '\\' . ucfirst($routeMatch->getControllerName()) . $this->controllerSuffix;
        $controller = $this->getController($FQCN);
        $action = $routeMatch->getActionName();

        return $controller->$action($request, $routeMatch->getRequestAttributes());
    }

    /**
     * Adds a controller to the controllers list
     * @param AbstractController $controller
     */
    public function addController(AbstractController $controller)
    {
        $this->controllers[] = $controller;
    }

    /**
     * Returns a controller with a given name from controllers list
     * @param string $controllerName
     * @return mixed
     */
    private function getController(string $controllerName)
    {
        foreach ($this->controllers as $controller) {
            if ($controllerName === get_class($controller)) {
                return $controller;
            }
        }

        //Arunca exceptie
    }
}