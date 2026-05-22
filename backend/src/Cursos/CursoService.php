<?php

namespace App\Cursos;

use App\Categorias\CategoriaRepository;
use App\Plataformas\PlataformaRepository;

use App\Cursos\Curso;

use App\Cursos\Exceptions\CursoNaoEncontradoException;
use App\Cursos\Exceptions\SemAlteracoesException;

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

    /**
     * @return Curso[]
     */
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
        // bool $gratuito
        float $custo
    ): Curso {
        $categoria = $this->categoriaRepository->buscarOuCriar($categoriaNome);

        $plataforma = $this->plataformaRepository->buscarOuCriar($plataformaNome);

        $id = $this->cursoRepository->criar(
            $nome,
            $descricao,
            $categoria->id,
            $plataforma->id,
            $url,
            // $gratuito
            $custo
        );

        return new Curso($id, $nome, $descricao, $categoria->nome, $plataforma->nome, $custo, $url);// $gratuito, $url);
    }

    public function editar(
        int $id,
        string $nome,
        ?string $descricao,
        string $categoriaNome,
        string $plataformaNome,
        string $url,
        // bool $gratuito
        float $custo
    ): Curso {

        // verificar se o curso existe
        $cursoAtual = $this->cursoRepository->buscarPorId($id);

        if (!$cursoAtual) {
            // controller mapeia pra 404
            throw new CursoNaoEncontradoException("Curso não encontrado.");
        }

        // verificar se houve alguma alteração
        $semAlteracoes = (
            $cursoAtual->getNome() === $nome &&
            $cursoAtual->getDescricao() === $descricao &&
            $cursoAtual->getCategoria() === $categoriaNome &&
            $cursoAtual->getPlataforma() === $plataformaNome &&
            //$cursoAtual->isGratuito() === $gratuito &&
            $cursoAtual->getCusto() === $custo &&
            $cursoAtual->getUrl() === $url
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
            //$gratuito
            $custo
        );

        return new Curso($id, $nome, $descricao, $categoriaNome, $plataformaNome, $custo, $url); // $gratuito, $url);
    }

    public function remover(int $id): bool
    {
        return $this->cursoRepository->remover($id);
    }
}