<?php declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/../vendor/autoload.php';

use App\Core\RestControllerFactory;
use App\Core\Router;
use App\Core\Env;

$frontendUrl = Env::get('FRONTEND_URL');

header("Access-Control-Allow-Origin: $frontendUrl");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') ?: '/';

$restControllerFactory = new RestControllerFactory();

$router = new Router($restControllerFactory);

$router->dispatch($method, $uri);