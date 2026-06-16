<?php declare(strict_types=1);

namespace App\Core;

use App\Auth\Exceptions\AcessoNegadoException;
use App\Auth\Exceptions\UsuarioNaoAutenticadoException;
use App\Auth\JwtMiddleware;

use App\Bootstrap\RestControllerFactory;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

use function FastRoute\simpleDispatcher;

class Router
{
    private Dispatcher $dispatcher; // FastRoute

    public function __construct(
        private readonly RestControllerFactory $restControllerFactory,
        private readonly JwtMiddleware $jwtMiddleware
    ) {
        $this->registrarRotas();
    }

    private function registrarRotas(): void
    {
        $controllers = $this->restControllerFactory->controllers();

        $this->dispatcher = simpleDispatcher(
            function(RouteCollector $r) use ($controllers) {
                foreach ($controllers as $controller)
                {
                    foreach ($controller::routes() as $route)
                    {
                        $r->addRoute(
                            $route->httpMethod->value,
                            $route->uri,
                            [$controller, $route]
                        );
                    }
                }
            }
        );
    }

    public function dispatch(string $method, string $uri): void
    {
        $routeInfo = $this->dispatcher->dispatch(
            $method,
            $uri
        );

        switch ($routeInfo[0])
        {
            case Dispatcher::NOT_FOUND:
                ApiResponse::erro('Rota não encontrada: ' . $uri, 404);

            case Dispatcher::METHOD_NOT_ALLOWED:
                ApiResponse::erro('Método não suportado: ' . $method, 405);

            case Dispatcher::FOUND:
                
                $handler = $routeInfo[1];

                $controllerClass = $handler[0];
                $route = $handler[1];
                
                $vars = $routeInfo[2];

                // Autorização (rotas privadas/restritas)
                $this->autorizar($route);

                $controller = $this->restControllerFactory->create(
                    $controllerClass
                );

                // conversão simples para int (como em /api/cursos/1)
                foreach ($vars as $key => $value)
                {
                    if (is_numeric($value))
                    {
                        $vars[$key] = (int) $value;
                    }
                }

                call_user_func_array(
                    [$controller, $route->action],
                    $vars
                );

                return;
        }
    }

    private function autorizar(Route $rota): void
    {
        if (!$rota->requerAuth)
        {
            return;
        }

        try {
            $this->jwtMiddleware->autorizarRequisicao($rota->perfilNecessario);

        } catch (AcessoNegadoException $e) {
            ApiResponse::erro('Usuário não autorizado', 403);

        } catch (UsuarioNaoAutenticadoException $e) {
            ApiResponse::erro('Usuário não autenticado', 401);
        }
    }
}
