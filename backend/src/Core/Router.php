<?php

namespace App\Core;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;

use function FastRoute\simpleDispatcher;

class Router
{
    private Dispatcher $dispatcher; // FastRoute

    public function __construct(
        private RestControllerFactory $restControllerFactory
    ) {
        $this->configurarFastRoute();
    }

    private function configurarFastRoute(): void
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
                http_response_code(404);

                echo json_encode([
                    'erro' => 'Rota não encontrada'
                ]);

                return;

            case Dispatcher::METHOD_NOT_ALLOWED:
                http_response_code(405);

                echo json_encode([
                    'erro' => 'Método não suportado',
                    'metodo' => $method
                ]);

                return;

            case Dispatcher::FOUND:
                
                $handler = $routeInfo[1];

                $controllerClass = $handler[0];
                $route = $handler[1];
                
                $vars = $routeInfo[2];

                // Autorização (rotas privadas/restritas)
                $this->autorizar($route);

                $controller = $this->restControllerFactory->build(
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

        // TODO: implementar JWT e tratar aqui.
        http_response_code(401);
        echo json_encode(['mensagem' => 'Ação não permitida']);
        throw new \RuntimeException("Ação não permitida");
    }
}
