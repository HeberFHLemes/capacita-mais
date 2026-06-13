<?php declare(strict_types=1);

namespace App\Bootstrap;

use App\Auth\AuthController;
use App\Auth\AuthService;
use App\Auth\JwtService;

use App\Carrinhos\CarrinhoController;
use App\Carrinhos\CarrinhoRepository;
use App\Carrinhos\CarrinhoService;

use App\Carrinhos\ItemCarrinhoValidator;
use App\Categorias\CategoriaController;
use App\Categorias\CategoriaRepository;
use App\Categorias\CategoriaService;

use App\Core\RestController;

use App\Cursos\CursoController;
use App\Cursos\CursoService;

use App\Database\Conexao;

use App\Usuarios\UsuarioRepository;
use App\Usuarios\UsuarioService;

use InvalidArgumentException;
use PDO;

/**
 * Abstrai a instanciação dos controllers, utilizando métodos privados
 * que se assemelham ao princípio da Injeção de Dependências.
 */
class RestControllerFactory
{
    private PDO $pdo;

    private array $controllerFactories;

    public function __construct() {
        $this->pdo = Conexao::getInstance();

        $this->registrarControllers();
    }

    /**
     * Registra o conjunto de controllers existentes
     * em um array associativo, com a chave sendo o class do controller,
     * e o valor sendo a função responsável por o instanciar.
     */
    private function registrarControllers(): void
    {
        $this->controllerFactories = [
            AuthController::class => fn() => $this->authController(),
            CarrinhoController::class => fn() => $this->carrinhoController(),
            CategoriaController::class => fn() => $this->categoriaController(),
            CursoController::class => fn() => $this->cursoController()
        ];
    }

    public function build(string $classe): RestController
    {
        $factory = $this->controllerFactories[$classe] ??
            throw new InvalidArgumentException("Controller não registrado: {$classe}");

        return $factory();
    }

    /**
     * Retorna um array contendo o class de todos os controllers registrados.
     */
    public function controllers(): array
    {
        return array_keys($this->controllerFactories);
    }

    private function cursoController(): CursoController
    {
        return new CursoController(CursoService::with($this->pdo));
    }

    private function categoriaController(): CategoriaController
    {
        return new CategoriaController(
            new CategoriaService(new CategoriaRepository($this->pdo))
        );
    }

    private function authController(): AuthController
    {
        return new AuthController(
            new AuthService(
                new UsuarioService(new UsuarioRepository($this->pdo)),
                new JwtService()
            )
        );
    }

    private function carrinhoController(): CarrinhoController
    {
        return new CarrinhoController(
            new CarrinhoService(new CarrinhoRepository($this->pdo)),
            new ItemCarrinhoValidator()
        );
    }
}