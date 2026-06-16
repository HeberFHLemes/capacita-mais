<?php declare(strict_types=1);

namespace App\Core;

use JsonException;

/**
 * Define o padrão de um controller desta API,
 * para que possam ser mais facilmente manipulados e instanciados, 
 * além de abstrair funcionalidades comuns.
 */
abstract class RestController
{
    /**
     * Para facilitar o mapeamento das rotas e a instanciação 
     * dos controllers, cada controller definirá suas próprias rotas
     * e o que executar para cada uma, em vez de fazer isso no Router.
     * 
     * @return array $routes
     */
    abstract public static function routes(): array;

    /**
     * Extrai o corpo da requisição, no formato JSON,
     * retornando um array associativo, ou retornando
     * uma mensagem de erro ao cliente por formato inválido.
     */
    protected function obterDadosDaRequisicao(): array
    {
        try {
            $dados = json_decode(
                file_get_contents('php://input'),
                true,
                flags: JSON_THROW_ON_ERROR
            );

            // Sempre esperamos objeto JSON, por isso se retorna 
            // ou um array associativo com os dados ou um vazio.
            return is_array($dados)
                ? $dados
                : [];
        } catch (JsonException $e) {
            error_log((string) $e);

            ApiResponse::erro('JSON inválido', 400);
        }
    }
}