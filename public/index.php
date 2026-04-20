<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Router\Router;

$uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') ?: '/';
$method = $_SERVER['REQUEST_METHOD'];

$router = new Router();

$router->dispatch($uri, $method);