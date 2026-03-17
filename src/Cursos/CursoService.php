<?php

namespace App\Cursos;

use App\Categorias\CategoriaRepository;
use App\Cursos\Curso;
use App\Database\Conexao;
use App\Plataformas\PlataformaRepository;
use PDO;

class CursoService 
{
    public function __construct(
        private CursoRepository $cursoRepository,
        private PlataformaRepository $plataformaRepository,
        private CategoriaRepository $categoriaRepository
    ) {}

    public function listarCursos(): array
    {
        return $this->cursoRepository->buscarTodos();
    }

    public function criar(
        string $nome,
        ?string $descricao,
        string $categoriaNome,
        string $plataformaNome,
        string $url,
        bool $gratuito
    ): Curso {
        $categoria = $this->categoriaRepository->buscarOuCriar($categoriaNome);

        $plataforma = $this->plataformaRepository->buscarOuCriar($plataformaNome);

        return $this->cursoRepository->criar(
            $nome,
            $descricao,
            $categoria->id,
            $plataforma->id,
            $url,
            $gratuito
        );
    }
}