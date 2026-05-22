<?php declare(strict_types=1);

namespace App\Cursos;

final class CursoValidator
{
    private function __construct() {}

    /**
     * Valida se há erros ou campos em branco
     * nos dados enviados de um curso.
     * 
     * @return $erros array contendo os nomes 
     * dos campos com erros encontrados e a descrição.
     */
    public static function validar(array $dados): array
    {
        $erros = [];

        if (empty($dados['nome'])) {
            $erros['nome'] = 'Nome é obrigatório';
        }

        if (empty($dados['categoria'])) {
            $erros['categoria'] = 'Categoria é obrigatória';
        }

        if (empty($dados['plataforma'])) {
            $erros['plataforma'] = 'Plataforma é obrigatória';
        }

        if (empty($dados['url'])) {
            $erros['url'] = 'URL é obrigatória';
        }

        if (!isset($dados['gratuito'])) {
            $erros['gratuito'] = 'Custo é obrigatório';
        }

        return $erros;
    }
}