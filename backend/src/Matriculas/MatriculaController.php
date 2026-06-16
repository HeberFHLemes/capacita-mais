<?php declare(strict_types=1);

namespace App\Matriculas;

use App\Auth\AuthContext;
use App\Core\ApiResponse;
use App\Core\HttpMethod;
use App\Core\RestController;
use App\Core\Route;

class MatriculaController extends RestController
{
    public static function routes(): array
    {
        return [
            new Route(HttpMethod::GET, '/matriculas', 'buscarCursosMatriculados', true)
        ];
    }

    public function __construct(
        private readonly MatriculaService $matriculaService
    ) {}

    public function buscarCursosMatriculados(): void
    {
        $usuarioId = AuthContext::getUsuario()->id;

        $cursos = $this->matriculaService->buscarCursosMatriculados($usuarioId);

        ApiResponse::json($cursos);
    }
}