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

        if (!isset($dados['nome']) || trim($dados['nome']) === '') {
            $erros['nome'] = 'Nome é obrigatório';
        }

        if (!isset($dados['categoria_id']) || !is_int($dados['categoria_id'])) {
            $erros['categoria'] = 'Categoria é obrigatória';
        }

        // TODO: validar com enum
        if (!isset($dados['nivel']) || trim($dados['nivel']) === '') {
            $erros['nivel'] = 'Nível é obrigatório';
        }

        if (!isset($dados['em_destaque']) || !is_bool($dados['em_destaque'])) {
            $erros['em_destaque'] = 'Em Destaque é obrigatório e deve ser booleano';
        }

        if (!isset($dados['preco']) || !is_numeric($dados['preco'])) {
            $erros['preco'] = 'Preço é obrigatório e deve ser numérico';
        }
        
        if (!isset($dados['preco_original']) || !is_numeric($dados['preco_original'])) {
            $erros['preco_original'] = 'Preço original é obrigatório e deve ser numérico';
        }

        return $erros;
    }
}