<?php

namespace App;

use App\Bootstrap\RestControllerFactory;

use App\Core\Router;

final class Application
{
    public function run(): void
    {
        $this->configurarHeaders();

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'OPTIONS') {
            http_response_code(204);
            exit;
        }

        $uri = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') ?: '/';

        $router = new Router(new RestControllerFactory());
        
        $router->dispatch($method, $uri);
    }

    private function configurarHeaders(): void
    {
        header('Content-Type: application/json; charset=utf-8');
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
    }
}