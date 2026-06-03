<?php declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require __DIR__ . '/../vendor/autoload.php';

use App\Core\RestControllerFactory;
use App\Core\Router;

try {
    /*
     * Usando o reverse proxy no frontend, seja com a config do Angular,
     * ou com o Nginx no Docker, não precisa configurar o CORS.
     * 
     * use App\Core\Env;
     * 
     * $frontendUrl = Env::get('FRONTEND_URL');
     *
     * header("Access-Control-Allow-Origin: $frontendUrl");
    */
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

} catch (\Throwable $e) { // para não retornar stacktrace
    error_log((string) $e);

    http_response_code(500);

    echo json_encode([
        'erros' => [ 'Erro interno no servidor' ]
    ]);

    exit;
}