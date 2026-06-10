<?php declare(strict_types=1);

namespace App\Core;

use JsonSerializable;
use Override;

/**
 * Classe para padronizar o retorno das informações
 * de erro da API, com uma mensagem e, opcionalmente,
 * um array (associativo ou não) de erros.
 */
readonly class ErrorResponse implements JsonSerializable
{
    public function __construct(
        private string $mensagem,
        private array $erros = []
    ) {}

    #[Override]
    public function jsonSerialize(): array
    {
        $response = [
            'mensagem' => $this->mensagem
        ];

        if ($this->erros !== []) {
            $response['erros'] = $this->erros;
        }

        return $response;
    }
}