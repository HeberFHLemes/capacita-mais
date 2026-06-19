<?php declare(strict_types=1);

namespace App\Cursos;

use App\Core\Validator;
use Override;

class CursoValidator extends Validator
{
    #[Override]
    public function validar(array $dados): void
    {
        $this->validarCampoNaoVazio($dados, 'nome');
        $this->validarNivel($dados);
        $this->validarCategoria($dados);
        $this->validarCampoObrigatorio($dados, 'preco');
        $this->validarCampoObrigatorio($dados, 'preco_original');
        $this->validarCampoObrigatorio($dados, 'em_destaque');
    }

    private function validarNivel(array $dados): void
    {
        $campo = 'nivel';
        $this->validarCampoNaoVazio($dados, $campo);

        if (!isset($this->erros[$campo])) {

            $nivel = $dados[$campo];

            // Para evitar fazer trim em outros tipos (TypeError por conta do strict_types!)
            if (is_string($nivel)) { 
                $nivel = strtolower(trim($nivel));

                $nivelValido = Nivel::tryFrom($nivel);

                if ($nivelValido !== null) {
                    return;
                }
            }

            $valoresValidos = implode(', ', array_column(Nivel::cases(), 'value'));

            $this->erros[$campo] = "O campo $campo deve ser um dos valores: $valoresValidos";
        }
    }

    private function validarCategoria(array $dados): void
    {
        $this->validarCampoObrigatorio($dados, 'categoria_id');
        $this->validarInteiro($dados, 'categoria_id');
    }
}