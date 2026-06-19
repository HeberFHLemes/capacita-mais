<?php declare(strict_types=1);

namespace App\Cursos;

use App\Categorias\CategoriaRepository;
use App\Categorias\CategoriaService;
use App\Categorias\Exceptions\CategoriaNaoEncontradaException;

use App\Cursos\Exceptions\CursoNaoEncontradoException;
use App\Cursos\Exceptions\SemAlteracoesException;

readonly class CursoService
{
    public function __construct(
        private CursoRepository  $cursoRepository,
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

    public function buscarCursoPorId(int $id): Curso
    {
        return $this->cursoRepository->buscarPorId($id)
            ?? throw new CursoNaoEncontradoException();
    }

    public function criar(
        string $nome,
        ?string $descricao,
        int $categoriaId,
        string $nivel,
        float $preco,
        float $precoOriginal,
        bool $emDestaque
    ): Curso {
        
        $categoria = $this->categoriaService->buscarPorId($categoriaId);

        if (!$categoria) {
            throw new CategoriaNaoEncontradaException("Categoria não encontrada.");
        }

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
            $categoria,
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
        int $categoriaId,
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

        // buscar ou criar categoria
        $categoria = $this->categoriaService->buscarPorId($categoriaId);
        
        if (!$categoria) {
            throw new CategoriaNaoEncontradaException("Categoria não encontrada.");
        }

        // verificar se houve alguma alteração
        $semAlteracoes = (
            $cursoAtual->getNome() === $nome &&
            $cursoAtual->getDescricao() === $descricao &&
            $cursoAtual->getCategoria()->id === $categoria->id &&
            $cursoAtual->getNivel() === $nivel &&
            $cursoAtual->getPreco() === $preco &&
            $cursoAtual->getPrecoOriginal() === $precoOriginal &&
            $cursoAtual->isEmDestaque() === $emDestaque
        );

        if ($semAlteracoes) {
            throw new SemAlteracoesException("Nenhuma alteração detectada."); 
        }

        // só então atualiza
        $this->cursoRepository->atualizar(
            $id, 
            $nome, 
            $descricao,
            $categoriaId, 
            $nivel,
            $preco, 
            $precoOriginal, 
            $emDestaque
        );

        return new Curso(
            $id, 
            $nome, 
            $descricao,
            $categoria, 
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