<?php

namespace App\Cursos;

use App\Categorias\CategoriaRepository;
use App\Categorias\CategoriaService;
use App\Cursos\Curso;

use App\Cursos\Exceptions\CursoNaoEncontradoException;
use App\Cursos\Exceptions\SemAlteracoesException;

class CursoService 
{
    public function __construct(
        private CursoRepository $cursoRepository,
        private CategoriaService $categoriaService
    ) {}

    public static function with(\PDO $pdo): self
    {
        return new CursoService(
            new CursoRepository($pdo),
            new CategoriaService(new CategoriaRepository($pdo))
        );
    }

    /**
     * @return Curso[]
     */
    public function listarCursos(): array
    {
        return $this->cursoRepository->buscarTodos();
    }

    /**
     * @return Curso[]
     */
    public function listarCursosEmDestaque(): array
    {
        return $this->cursoRepository->buscarCursosEmDestaque();
    }

    public function criar(
        string $nome,
        ?string $descricao,
        string $categoriaNome,
        string $nivel,
        float $preco,
        float $precoOriginal,
        bool $emDestaque
    ): Curso {
        $categoria = $this->categoriaService->buscarOuCriar($categoriaNome);

        $id = $this->cursoRepository->criar(
            $nome,
            $descricao,
            $categoria->id,
            $nivel,
            $preco,
            $precoOriginal,
            $emDestaque
        );

        return new Curso(
            $id, 
            $nome,
            $descricao,
            $categoria->nome,
            $nivel,
            $preco,
            $precoOriginal,
            $emDestaque
        );
    }

    public function editar(
        int $id,
        string $nome,
        ?string $descricao,
        string $categoriaNome,
        string $nivel,
        float $preco,
        float $precoOriginal,
        bool $emDestaque
    ): Curso {

        // verificar se o curso existe
        $cursoAtual = $this->cursoRepository->buscarPorId($id);

        if (!$cursoAtual) {
            throw new CursoNaoEncontradoException("Curso não encontrado.");
        }

        // verificar se houve alguma alteração
        $semAlteracoes = (
            $cursoAtual->getNome() === $nome &&
            $cursoAtual->getDescricao() === $descricao &&
            $cursoAtual->getCategoria() === $categoriaNome &&
            $cursoAtual->getNivel() === $nivel &&
            $cursoAtual->getPreco() === $preco &&
            $cursoAtual->getPrecoOriginal() === $precoOriginal &&
            $cursoAtual->isEmDestaque() === $emDestaque
        );

        if ($semAlteracoes) {
            throw new SemAlteracoesException("Nenhuma alteração detectada."); 
        }

        // buscar ou criar categoria
        $categoria  = $this->categoriaService->buscarOuCriar($categoriaNome);

        // só então atualiza
        $this->cursoRepository->atualizar(
            $id, 
            $nome, 
            $descricao,
            $categoria->id, 
            $nivel,
            $preco, 
            $precoOriginal, 
            $emDestaque
        );

        return new Curso(
            $id, 
            $nome, 
            $descricao,
            $categoria->nome, 
            $nivel,
            $preco, 
            $precoOriginal, 
            $emDestaque
        );
    }

    public function remover(int $id): bool
    {
        return $this->cursoRepository->remover($id);
    }
}