<?php
use Framework\Application;
use Framework\Http\Request;
use Framework\Router\Router;


// obtain the base directory for the web application a.k.a. document root
$baseDir = dirname(__DIR__);

// setup auto-loading
require $baseDir.'/vendor/autoload.php';



$config = require '/var/www/mvc-framework-skeleton/config/config.php';
$router = new Router($config);
$request = new Request();
$match = $router->route($request);
print_r($match);


// obtain the DI container
//$container = require $baseDir.'/config/services.php';

// create the application and handle the request
//$application = Application::create($container);
//$request = Request::createFromGlobals();
//$response = $application->handle($request);
//$response->send();


