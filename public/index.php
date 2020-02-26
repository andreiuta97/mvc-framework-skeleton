<?php

use Framework\Application;
use Framework\Http\Request;
use Framework\Router\Router;

ini_set('display_errors', true);

// obtain the base directory for the web application a.k.a. document root
$baseDir = dirname(__DIR__);

// setup auto-loading
require $baseDir . '/vendor/autoload.php';
try {
    $config = require $baseDir . '/config/config.php';
    $router = new Router($config['router']);
    $request = new Request();

    $match = $router->route($request);
    var_dump($match);
} catch (\Framework\Exceptions\RouterException $ex) {
    print 'Problems with router';
    print $ex->getMessage();
}

// obtain the DI container
//$container = require $baseDir.'/config/services.php';

// create the application and handle the request
//$application = Application::create($container);
//$request = Request::createFromGlobals();
//$response = $application->handle($request);
//$response->send();


