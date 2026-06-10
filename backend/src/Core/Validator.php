<?php

namespace App\Core;

/**
 * Classe para implementação das validações iniciais
 * dos campos recebidos em requisições.
 */
abstract class Validator
{
    protected array $erros = [];

    abstract public function validar(array $dados): void;

    public function getErros(): array
    {
        return $this->erros;
    }

    public function validacaoFalhou(): bool
    {
        return !empty($this->erros);
    }

    /**
     * Verifica se um campo, com valor diferente de null está presente em um array.
     * Não identifica como erro strings vazias ("", "  ").
     *
     * @param array $dados
     * @param string $campo
     * @return void
     *
     * @see Validator::validarCampoNaoVazio Utilizar este método para validar strings em branco
     */
    protected function validarCampoObrigatorio(array $dados, string $campo): void
    {
        if (!array_key_exists($campo, $dados) || $dados[$campo] === null) {
            $this->erros[$campo] = "O campo $campo é obrigatório";
        }
    }

    /**
     * Valida se um array contém um $campo específico,
     * e se o valor não é uma string vazia ou null.
     *
     * @param array $dados
     * @param string $campo
     * @return void
     */
    protected function validarCampoNaoVazio(array $dados, string $campo): void
    {
        if (!array_key_exists($campo, $dados) || $dados[$campo] === '' || $dados[$campo] === null) {
            $this->erros[$campo] = "O campo $campo não pode ser vazio";
        }
    }

    /**
     * Valida um e-mail com a função filter_var.
     *
     * @param array $dados
     * @param string $campo
     * @return void
     */
    protected function validarEmail(array $dados, string $campo): void
    {
        if (!filter_var($dados[$campo] ?? '', FILTER_VALIDATE_EMAIL)) {
            $this->erros[$campo] = "O campo $campo deve ser um e-mail válido";
        }
    }

    /**
     * Valida que uma string tem um tamanho mínimo específico.
     *
     * @param array $dados
     * @param string $campo
     * @param int $min
     * @return void
     */
    protected function validarTamanhoMinimo(array $dados, string $campo, int $min): void
    {
        if (strlen($dados[$campo] ?? '') < $min) {
            $this->erros[$campo] = "O campo $campo deve ter no mínimo $min caracteres";
        }
    }
}