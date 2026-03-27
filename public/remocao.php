<?php
  require_once __DIR__ . '/../vendor/autoload.php';
  use App\Auth\AuthService;
  
  $authService = new AuthService();
  $authService->exigirLogin();
?>
<!doctype html>
<html lang="pt-BR">
  <?php
    require __DIR__ . '/components/head.php';
    gerarHead("Remover Curso | Capacita+")
  ?>
  <body class="bg-light d-flex flex-column justify-content-center align-items-center min-vh-100">
    <div class="container my-5">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <ul class="nav nav-underline justify-content-center">
            <li class="nav-item">
              <a class="nav-link formulario-link" href="/cadastro.php">Cadastrar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link formulario-link" href="/edicao.php">Editar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link formulario-link active" aria-current="page" href="/remocao.php">Remover</a>
            </li>
          </ul>
          <div class="card shadow-sm p-4">
            <h1 class="h4 mb-4 text-center">Remover Curso</h1>

            <form id="form-remocao-curso">
              <div class="mb-3">
                <label for="select-cursos-remocao" class="form-label">Curso</label>
                <select
                  class="form-select"
                  id="select-cursos-remocao"
                  name="select-cursos-remocao"
                  aria-placeholder="Curso a ser removido"
                ></select>
              </div>

              <button type="submit" class="btn btn-outline-danger w-100">Remover Curso</button>
            </form>

            <div id="msg-remocao" class="alert alert-success mt-3 d-none" role="alert"></div>

            <p class="text-center mt-4">
              <a href="/index.php" class="text-decoration-none">Voltar ao site principal</a>
            </p>
          </div>
        </div>
      </div>
    </div>

    <script src="/js/remocao.js" type="module"></script>
  </body>
</html>
