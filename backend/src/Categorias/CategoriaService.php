<?php declare(strict_types=1);

namespace App\Categorias;

use App\Categorias\Exceptions\CategoriaJaExistenteException;
use App\Utils\Normalizador;

readonly class CategoriaService
{
    public function __construct(
        private CategoriaRepository $categoriaRepository
    ) {}

    public function buscarTodas(): array
    {
        return $this->categoriaRepository->buscarTodas();
    }

    public function buscarOuCriar(string $nome): Categoria
    {
        $nomeNormalizado = Normalizador::normalizarTexto($nome);

        $categoria = $this->categoriaRepository->buscarPorNormalizado($nomeNormalizado);
        
        if ($categoria) {
            return $categoria;
        }

        try {
            return $this->categoriaRepository->criar($nome, $nomeNormalizado);
        } catch (\PDOException $e) {
            // caso já foi inserido (outra requisição/unique)
            $categoria = $this->categoriaRepository->buscarPorNormalizado($nomeNormalizado);
            if ($categoria === null) {
                throw $e;
            }
            return $categoria;
        }
    }

    public function buscarPorId(int $id): ?Categoria
    {
        return $this->categoriaRepository->buscarPorId($id);
    }

    public function criar(string $nome): Categoria
    {
        $nomeNormalizado = Normalizador::normalizarTexto($nome);

        $categoria = $this->categoriaRepository->buscarPorNormalizado($nomeNormalizado);

        if ($categoria) {
            throw new CategoriaJaExistenteException();
        }

        return $this->categoriaRepository->criar($nome, $nomeNormalizado);
    }

    public function editar(int $id, string $nome): Categoria
    {
        $nomeNormalizado = Normalizador::normalizarTexto($nome);

        $categoria = $this->categoriaRepository->buscarPorNormalizado($nomeNormalizado);

        if ($categoria) {
            throw new CategoriaJaExistenteException();
        }

        $this->categoriaRepository->atualizar($id, $nome, $nomeNormalizado);

        return new Categoria($id, $nome, $nomeNormalizado);
    }

    public function remover(int $id): bool
    {
        return $this->categoriaRepository->remover($id);
    }
}