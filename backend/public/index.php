<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Router\Router;
use App\Utils\Env;

$frontendUrl = Env::get('FRONTEND_URL');

header("Access-Control-Allow-Origin: $frontendUrl");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') ?: '/';
$method = $_SERVER['REQUEST_METHOD'];

$router = new Router();

$router->dispatch($uri, $method);