<?php

use Framework\Contracts\DispatcherInterface;
use Framework\Contracts\RendererInterface;
use Framework\Contracts\RouterInterface;
use Framework\Controller\UserController;
use Framework\Contracts\ContainerInterface;
use Framework\Dispatcher\Dispatcher;
use Framework\Renderer\Renderer;
use Framework\Router\Router;
use Framework\DependencyInjection\SymfonyContainer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

$containerBuilder = new ContainerBuilder();

$config = require 'config.php';

$containerBuilder->setParameter('routerConfig',$config['router']);
$containerBuilder->register(RouterInterface::class, Router::class)
    ->addArgument('%routerConfig%');

$containerBuilder->setParameter('rendererConfig',$config['renderer']['base_view_path']);
$containerBuilder->register(RendererInterface::class, Renderer::class)
    ->addArgument('%rendererConfig%');

$containerBuilder->register(UserController::class, UserController::class)
    ->addArgument(new Reference(RendererInterface::class));

$containerBuilder->setParameter('dispatcherConfig',$config['dispatcher']);
$containerBuilder->register(DispatcherInterface::class, Dispatcher::class)
    ->addArgument('%dispatcherConfig%')
    ->addMethodCall('addController', [new Reference(UserController::class)]);

// .........


return new SymfonyContainer($containerBuilder);