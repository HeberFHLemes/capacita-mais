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
    gerarHead("Cadastrar Curso | Capacita+")
  ?>
  <body class="bg-light d-flex flex-column justify-content-center align-items-center min-vh-100">
    <div class="container my-5">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <ul class="nav nav-underline justify-content-center">
            <li class="nav-item">
              <a class="nav-link formulario-link active" aria-current="page" href="/cadastro.php">Cadastrar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link formulario-link" href="/edicao.php">Editar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link formulario-link" href="/remocao.php">Remover</a>
            </li>
          </ul>
          <div class="card shadow-sm p-4">
            <h1 class="h4 mb-4 text-center">Cadastrar Novo Curso</h1>

            <form id="form-cadastro-curso">
              <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control" required />
              </div>

              <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea id="descricao" name="descricao" class="form-control" rows="3"></textarea>
              </div>

              <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <input type="text" id="categoria" name="categoria" class="form-control" required />
              </div>

              <div class="mb-3">
                <label for="plataforma" class="form-label">Plataforma</label>
                <input type="text" id="plataforma" name="plataforma" class="form-control" required />
              </div>

              <div class="mb-3">
                <label for="custo" class="form-label">Custo</label>
                <select id="custo" name="custo" class="form-select" required>
                  <option value="Gratuito">Gratuito</option>
                  <option value="Pago">Pago</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="link" class="form-label">Link do Curso</label>
                <input
                  type="url"
                  id="link"
                  name="link"
                  class="form-control"
                  placeholder="https://..."
                  required
                />
              </div>

              <button type="submit" class="btn btn-primary w-100">Cadastrar Curso</button>
            </form>

            <div id="msg" class="alert alert-success mt-3 d-none" role="alert"></div>

            <p class="text-center mt-4">
              <a href="/index.php" class="text-decoration-none">Voltar ao site principal</a>
            </p>
          </div>
        </div>
      </div>
    </div>

    <script src="/js/cadastro.js" type="module"></script>
  </body>
</html>
