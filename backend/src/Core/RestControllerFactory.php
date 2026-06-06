<?php

namespace App\Core;

use App\Auth\AuthController;
use App\Auth\AuthService;
use App\Auth\JwtService;

use App\Categorias\CategoriaController;
use App\Categorias\CategoriaRepository;
use App\Categorias\CategoriaService;

use App\Cursos\CursoController;
use App\Cursos\CursoService;

use App\Database\Conexao;

use App\Usuarios\UsuarioRepository;
use App\Usuarios\UsuarioService;

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
            AuthController::class => $this->authController(),
            default => throw new \InvalidArgumentException(
                "Controller não registrado: {$classe}"
            )
        };
    }

    /**
     * Retorna um array contendo o class de todos os controllers registrados.
     */
    public function controllers(): array
    {
        return [
            CursoController::class,
            CategoriaController::class,
            AuthController::class
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

    private function authController(): AuthController
    {
        return new AuthController(new AuthService(
            new UsuarioService(new UsuarioRepository($this->pdo)),
            new JwtService()
        ));
    }
}