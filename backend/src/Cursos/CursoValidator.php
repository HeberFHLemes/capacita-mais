<?php declare(strict_types=1);

namespace App\Cursos;

final class CursoValidator
{
    private function __construct() {}

    /**
     * Valida se há erros ou campos em branco
     * nos dados enviados de um curso.
     * 
     * @return array $erros array contendo os nomes 
     * dos campos com erros encontrados e a descrição.
     */
    public static function validar(array $dados): array
    {
        $erros = [];

        if (empty($dados['nome'])) {
            $erros['nome'] = 'Nome é obrigatório';
        }

        if (empty($dados['categoria_id'])) {
            $erros['categoria'] = 'Categoria é obrigatória';
        }

        if (empty($dados['nivel'])) {
            $erros['nivel'] = 'Nível é obrigatório';
        }

        if (empty($dados['em_destaque'])) {
            $erros['em_destaque'] = 'Em Destaque é obrigatório';
        }

        if (!isset($dados['preco'])) {
            $erros['preco'] = 'Preço é obrigatório';
        }
        
        if (!isset($dados['preco_original'])) {
            $erros['preco_original'] = 'Preço original é obrigatório';
        }

        return $erros;
    }
}