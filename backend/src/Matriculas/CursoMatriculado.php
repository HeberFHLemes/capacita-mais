<?php declare(strict_types=1);

namespace App\Matriculas;

use DateTimeInterface;
use JsonSerializable;
use Override;

readonly class CursoMatriculado implements JsonSerializable
{
    public function __construct(
        public int $id,
        public string $nome,
        public DateTimeInterface $dataCompra
    ) {}

    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'data_compra' => $this->dataCompra->format(DateTimeInterface::ATOM)
        ];
    }
}