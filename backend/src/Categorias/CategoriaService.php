<?php

namespace App\Categorias;

use App\Utils\Normalizador;

class CategoriaService 
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
        return $this->buscarOuCriar($nome);
    }
}