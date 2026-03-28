<?php
  require_once __DIR__ . '/../vendor/autoload.php';

  use App\Auth\Authenticator;
  use App\Auth\AuthService;
  use App\Database\Conexao;
  use App\Usuarios\UsuarioRepository;
  
  $erro = '';

  try {
    $pdo = Conexao::getInstance();
    
    $autenticador = new Authenticator(
      new UsuarioRepository($pdo)
    );

    $authService = new AuthService();
    $authService->iniciarSessao();

    if ($authService->usuarioLogado()) {
      header('Location: /cadastro.php');
      exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
      $senha = trim($_POST['senha'] ?? '');

      if ($email && $senha !== '') {
        $usuario = $autenticador->autenticar($email, $senha);

        if ($usuario) {
          $authService->login($usuario);

          header('Location: /cadastro.php');
          exit;
        }
      }
      $erro = "E-mail ou senha inválidos.";
    }
  } catch (\Throwable $e) {
    error_log($e);

    $erro = "Sistema temporariamente indisponível.";
  }
?>
<!doctype html>
<html lang="pt-BR">
  <?php
    require __DIR__ . '/components/head.php';
    gerarHead("Login | Capacita+")
  ?>
  <body class="bg-light d-flex flex-column justify-content-center align-items-center min-vh-100">
    <main class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">
      <h1 class="h4 text-center mb-4">Acesso Administrativo</h1>

      <?php if ($erro): ?>
        <div class="alert alert-danger" role="alert">
          <?= htmlspecialchars($erro) ?>
        </div>
      <?php endif; ?>

      <form id="form-login" method="post" action="/login.php">
        <div class="mb-3">
          <label for="email" class="form-label">E-mail</label>
          <input
            autofocus="on"
            type="email"
            name="email"
            id="email"
            class="form-control"
            required
            placeholder="admin@capacita.com"
          />
        </div>

        <div class="mb-3">
          <label for="senha" class="form-label">Senha</label>
          <input type="password" id="senha" name="senha" class="form-control" required placeholder="••••••••" />
        </div>

        <button type="submit" class="btn btn-primary w-100">Entrar</button>
      </form>

      <p class="text-center mt-3">
        <a href="/index.php" class="text-decoration-none">Voltar ao site principal</a>
      </p>
    </main>
  </body>
</html>
