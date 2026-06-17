<?php declare(strict_types=1);

namespace App\Carrinhos;

use App\Auth\AuthContext;
use App\Auth\Exceptions\UsuarioNaoAutenticadoException;

use App\Carrinhos\Exceptions\ItemCarrinhoJaExisteException;

use App\Core\ApiResponse;
use App\Core\HttpMethod;
use App\Core\RestController;
use App\Core\Route;

use App\Cursos\Exceptions\CursoNaoEncontradoException;

class CarrinhoController extends RestController
{
    public function __construct(
        private readonly CarrinhoService $carrinhoService,
        private readonly ItemCarrinhoValidator $itemCarrinhoValidator
    ) {}

    public static function routes(): array
    {
        return [
            new Route(HttpMethod::GET, '/carrinho', 'buscarCarrinho', true),
            new Route(HttpMethod::POST, '/carrinho/itens', 'inserirItem', true),
            new Route(HttpMethod::DELETE, '/carrinho/itens/{cursoId:\d+}', 'removerItem', true)
        ];
    }

    public function buscarCarrinho(): void
    {
        $usuarioId = $this->identificarUsuario();

        $carrinho = $this->carrinhoService->buscarCarrinho($usuarioId);

        ApiResponse::json($carrinho);
    }

    public function inserirItem(): void
    {
        $usuarioId = $this->identificarUsuario();
        $cursoId = $this->obterCursoIdDaRequisicao();

        try {
            $item = $this->carrinhoService->inserirItem($usuarioId, $cursoId);
            ApiResponse::json($item, 201);

        } catch (CursoNaoEncontradoException $e) {
            ApiResponse::erro(
                'Não foi possível adicionar o item ao carrinho',
                404,
                ['Curso não encontrado']
            );
        } catch (ItemCarrinhoJaExisteException $e) {
            ApiResponse::erro(
                'Não foi possível adicionar o item ao carrinho',
                409,
                ['Item já está no carrinho']
            );
        }
    }

    public function removerItem(int $cursoId): void
    {
        $usuarioId = $this->identificarUsuario();

        $ok = $this->carrinhoService->removerItem($usuarioId, $cursoId);

        if ($ok) {
            http_response_code(204);
            exit;
        }

        ApiResponse::erro('Item não está no carrinho ou não existe', 404);
    }

    private function identificarUsuario(): int
    {
        $usuario = AuthContext::getUsuario();

        if (empty($usuario)) {
            throw new UsuarioNaoAutenticadoException();
        }

        return $usuario->id;
    }

    private function obterCursoIdDaRequisicao(): int
    {
        $dados = $this->obterDadosDaRequisicao();

        $this->itemCarrinhoValidator->validar($dados);

        if ($this->itemCarrinhoValidator->validacaoFalhou()) {
            ApiResponse::erro(
                'Dados inválidos',
                422,
                $this->itemCarrinhoValidator->getErros()
            );
        }

        return (int) $dados['curso_id'];
    }
}