<?php

namespace App\Auth;

// TODO:
// Refatorar para diminuir repetição de código
class AuthValidator
{
    private function __construct() {}

    public static function validarLogin(array $dados): array
    {
        $erros = [];

        if (!isset($dados['email']) || trim($dados['email']) === '') {
            $erros['email'] = 'E-mail é obrigatório';
        }

        if (!isset($dados['senha']) || trim($dados['senha']) === '') {
            $erros['senha'] = 'Senha é obrigatória';
        }

        return $erros;
    }

    public static function validarCadastro(array $dados): array
    {
        $erros = [];

        if (!isset($dados['email']) || trim($dados['email']) === '') {
            $erros['email'] = 'E-mail é obrigatório';
        }

        if (!isset($dados['nome']) || trim($dados['nome']) === '') {
            $erros['nome'] = 'Nome é obrigatório';
        }

        if (!isset($dados['senha']) || trim($dados['senha']) === '') {
            $erros['senha'] = 'Senha é obrigatória';
        }

        return $erros;
    }
}