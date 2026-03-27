<?php

namespace App\Cursos;

use App\Categorias\CategoriaRepository;
use App\Plataformas\PlataformaRepository;

use App\Cursos\Curso;
use App\Cursos\CursoNaoEncontradoException;
use App\Cursos\SemAlteracoesException;

class CursoService 
{
    public function __construct(
        private CursoRepository $cursoRepository,
        private PlataformaRepository $plataformaRepository,
        private CategoriaRepository $categoriaRepository
    ) {}

    public static function with(\PDO $pdo): self
    {
        return new CursoService(
            new CursoRepository($pdo),
            new PlataformaRepository($pdo),
            new CategoriaRepository($pdo)
        );
    }

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

        $id = $this->cursoRepository->criar(
            $nome,
            $descricao,
            $categoria->id,
            $plataforma->id,
            $url,
            $gratuito
        );

        return new Curso($id, $nome, $descricao, $categoria->nome, $plataforma->nome, $gratuito, $url);
    }

    public function editar(
        int $id,
        string $nome,
        ?string $descricao,
        string $categoriaNome,
        string $plataformaNome,
        string $url,
        bool $gratuito
    ): Curso {

        // verificar se o curso existe
        $cursoAtual = $this->cursoRepository->buscarPorId($id);

        if (!$cursoAtual) {
            // controller mapeia pra 404
            throw new CursoNaoEncontradoException("Curso não encontrado.");
        }

        // verificar se houve alguma alteração
        $semAlteracoes = (
            $cursoAtual['nome'] === $nome &&
            $cursoAtual['descricao'] === $descricao &&
            $cursoAtual['categoria'] === $categoriaNome &&
            $cursoAtual['plataforma'] === $plataformaNome &&
            $cursoAtual['url'] === $url &&
            $cursoAtual['gratuito'] === $gratuito
        );

        if ($semAlteracoes) {
            // controller mapeia pra 200
            throw new SemAlteracoesException("Nenhuma alteração detectada."); 
        }

        // buscar ou criar categoria e plataforma
        $categoria  = $this->categoriaRepository->buscarOuCriar($categoriaNome);
        $plataforma = $this->plataformaRepository->buscarOuCriar($plataformaNome);

        // só então atualiza
        $this->cursoRepository->atualizar(
            $id, 
            $nome, 
            $descricao,
            $categoria->id, 
            $plataforma->id,
            $url, 
            $gratuito
        );

        return new Curso($id, $nome, $descricao, $categoriaNome, $plataformaNome, $gratuito, $url);
    }

    public function remover(int $id): bool
    {
        return $this->cursoRepository->remover($id);
    }
}