<?php declare(strict_types=1);

namespace Tests\Utils;

use App\Utils\Normalizador;

use PHPUnit\Framework\TestCase;

final class NormalizadorTest extends TestCase
{
    public function testRemoveAcentos()
    {
        $this->assertEquals(
            'programacao',
            Normalizador::normalizarTexto("programacão")
        );
    }

    public function testMudaParaLowercase()
    {
        $this->assertEquals(
            'programacao',
            Normalizador::normalizarTexto("PROGRAMACAO")
        );
    }

    public function testRemoveCaracteresEspeciais()
    {
        $this->assertEquals(
            'backend',
            Normalizador::normalizarTexto("Back-End")
        );
    }

    public function testNormalizaTextoCompleto()
    {
        $this->assertEquals(
            'programacaobackend',
            Normalizador::normalizarTexto("Programação Back-End")
        );
    }

    public function testNormalizaParaComparacao()
    {
        $primeiraPalavra = Normalizador::normalizarTexto("Programação Back-End");

        $segundaPalavra = Normalizador::normalizarTexto("programacao-backend");

        $this->assertEquals($primeiraPalavra, $segundaPalavra);

    }

    public function testStringVazia()
    {
        $this->assertEquals(
            '',
            Normalizador::normalizarTexto('')
        );
    }
}