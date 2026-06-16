<?php declare(strict_types=1);

namespace App\Bootstrap;

use App\Auth\AuthController;
use App\Carrinhos\CarrinhoController;
use App\Categorias\CategoriaController;
use App\Compras\CompraController;
use App\Core\RestController;
use App\Cursos\CursoController;
use App\Matriculas\MatriculaController;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use InvalidArgumentException;
use RuntimeException;

/**
 * Abstrai a instanciação dos controllers, utilizando
 * o container de injeção de dependências (do PHP-DI) internamente.
 */
final readonly class RestControllerFactory
{
    private const array CONTROLLERS = [
        AuthController::class,
        CarrinhoController::class,
        CategoriaController::class,
        CursoController::class,
        CompraController::class,
        MatriculaController::class
    ];

    public function __construct(private ContainerInterface $container) {}

    /**
     * Cria ou obtém um objeto de uma classe que
     * implementa a classe abstrata {@link RestController},
     * se ela existe e já está registrada internamente.
     *
     * @param class-string<RestController> $classe
     * @return RestController o controller requisitado
     */
    public function create(string $classe): RestController
    {
        if (!in_array($classe, self::CONTROLLERS, true)) {
            throw new InvalidArgumentException(
                "Controller não registrado: $classe"
            );
        }

        try {
            return $this->container->get($classe);

        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
            // Mapeia para RuntimeException para não ter de conhecer
            // as exceções do PHP-DI onde não se deveria conhecê-las.
            throw new RuntimeException("Erro ao obter o controller", previous: $e);
        }
    }

    /**
     * @return class-string<RestController>[]
     */
    public function controllers(): array
    {
        return self::CONTROLLERS;
    }
}