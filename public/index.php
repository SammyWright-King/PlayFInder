<?php

use Playfinder\Router;
use Slim\Psr7\Factory\ServerRequestFactory;

require __DIR__ . '/../vendor/autoload.php';

$router = new Router();
$router->handle(ServerRequestFactory::createFromGlobals());

