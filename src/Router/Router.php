<?php 

namespace App\Router;

use App\Router\ApiRouter;

use App\Auth\AuthService;
use App\Cursos\CursoController;
use App\Cursos\CursoService;
use App\Database\Conexao;

class Router
{
    public function dispatch(string $uri, string $method): void
    {
        if (str_starts_with($uri, '/api')) {
            $this->handleApi($uri, $method);
            return;
        }

        $this->handleWeb($uri);
    }

    private function handleApi(string $uri, string $method): void
    {
        $pdo = Conexao::getInstance();

        $apiRouter = new ApiRouter(
            new CursoController(CursoService::with($pdo)),
            new AuthService()
        );

        $apiRouter->handle($uri, $method);
    }

    private function handleWeb(string $uri): void
    {
        if (str_ends_with($uri, '.php')) {
            $clean = substr($uri, 0, -4) ?: '/';
            header("Location: $clean", true, 301);
            exit;
        }

        $routes = [
            '/' => '/home.php',
            '/cursos' => '/cursos.php',
            '/sobre' => '/sobre.php',
            '/login' => '/login.php',
            '/logout' => '/logout.php',
            '/cadastro' => '/cadastro.php',
            '/edicao' => '/edicao.php',
            '/remocao' => '/remocao.php',
        ];

        if (isset($routes[$uri])) {
            $view = __DIR__ . '/../Views' . $routes[$uri];

            if (file_exists($view)) {
                require $view;
                return;
            }
        }

        http_response_code(404);
        require __DIR__ . '/../Views/404.php';
    }
}
