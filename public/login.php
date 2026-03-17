<?php
  require_once __DIR__ . '/../vendor/autoload.php';
  use App\Auth\AuthService;
  use App\Usuarios\UsuarioRepository;
  
  $erro = '';
  
  $authService = new AuthService(new UsuarioRepository());

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = trim($_POST['senha'] ?? '');
    
    $usuario = $authService->autenticar($email, $senha);

    if ($usuario) {
      session_start();
      session_regenerate_id(true);

      $_SESSION['admin_id'] = $usuario->getId();

      header('Location: /cadastro.php');
      exit;
    }  
    $erro = "E-mail ou senha inválidos.";
  }
?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | Capacita+</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap"
    />
    <link rel="stylesheet" href="/css/styles.css" />
  </head>
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
        <a href="/index.html" class="text-decoration-none">Voltar ao site principal</a>
      </p>
    </main>
  </body>
</html>
