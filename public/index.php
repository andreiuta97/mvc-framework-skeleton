<?php

use Framework\Application;
use Framework\Http\Request;
use Framework\Router\Router;
use Framework\Dispatcher\Dispatcher;
use Framework\Renderer\Renderer;
use Framework\Controller\UserController;

ini_set('display_errors', true);

// obtain the base directory for the web application a.k.a. document root
$baseDir = dirname(__DIR__);

// setup auto-loading
require $baseDir . '/vendor/autoload.php';

//$uri = 'http://rares:rares123@www.test.com:80/user/1?y=3#wtf';
//parse_url($uri, $component = -1 );
try {
    $config = require $baseDir . '/config/config.php';
    $router = new Router($config['router']);
    $request = Request::createFromGlobals();
    $renderer = new Renderer($config['renderer'][Renderer::CONFIG_KEY_BASE_VIEW_PATH]);
    $userController = new UserController($renderer);
    $dispatcher = new Dispatcher($config['dispatcher']);
    $dispatcher->addController($userController);
    //instantiez controller
    //adauga pe dispatcher
    $routeMatch = $router->route($request);
    $response = $dispatcher->dispatch($routeMatch, $request);
    $response->send();
    //var_dump($routeMatch);
} catch (\Framework\Exceptions\RouterException $ex) {
    print 'Problems with router';
    print $ex->getMessage();
}

/*$stream =  \Framework\Http\Stream::createFromString('abc');
var_dump($stream->getContents());
//$uri = new \Framework\Http\Uri('http', 'abc', 'abc1', 'wwww.abc.com', 80, '/user/1', 'y=3', 'vbdf');
//echo $uri;
$request = \Framework\Http\Request::createFromGlobals();
var_dump($request);
*/

// obtain the DI container
//$container = require $baseDir.'/config/services.php';

// create the application and handle the request
//$application = Application::create($container);
//$request = Request::createFromGlobals();
//$response = $application->handle($request);
//$response->send();
