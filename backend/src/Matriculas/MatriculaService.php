<?php declare(strict_types=1);

namespace App\Matriculas;

readonly class MatriculaService
{

    public function __construct(private MatriculaRepository $matriculaRepository) {}

    /**
     * @param int $usuarioId
     * @return CursoMatriculado[]
     */
    public function buscarCursosMatriculados(int $usuarioId): array
    {
        return $this->matriculaRepository->buscarMatriculasDoUsuario($usuarioId);
    }
}