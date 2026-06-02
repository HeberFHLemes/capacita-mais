<?php

namespace App\Core;

use App\Categorias\CategoriaController;
use App\Categorias\CategoriaRepository;
use App\Categorias\CategoriaService;
use App\Cursos\CursoController;
use App\Cursos\CursoService;

use App\Database\Conexao;
use PDO;

/**
 * Abstrai a instanciação dos controllers, utilizando métodos privados
 * que se assemelham ao princípio da Injeção de Dependências.
 */
class RestControllerFactory
{
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Conexao::getInstance();
    }

    public function build(string $classe): RestController
    {
        return match ($classe) {
            CursoController::class => $this->cursoController(),
            CategoriaController::class => $this->categoriaController(),
            default => throw new \Exception("Classe desconhecida"),
        };
    }

    /**
     * Retorna um array contendo o class de todos os controllers registrados.
     */
    public function controllers(): array
    {
        return [
            CursoController::class,
            CategoriaController::class
        ];
    }

    private function cursoController(): CursoController
    {
        return new CursoController(CursoService::with($this->pdo));
    }

    private function categoriaController(): CategoriaController
    {
        return new CategoriaController(
            new CategoriaService(new CategoriaRepository($this->pdo))
        );
    }
}