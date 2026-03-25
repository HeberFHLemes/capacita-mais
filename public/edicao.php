<?php
  require_once __DIR__ . '/../vendor/autoload.php';
  use App\Auth\AuthService;
  
  $authService = new AuthService();
  $authService->exigirLogin();
?>
<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Curso | Capacita+</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap"
    />
    <link rel="stylesheet" href="css/styles.css" />
  </head>
  <body class="bg-light d-flex flex-column justify-content-center align-items-center min-vh-100">
    <div class="container my-5">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <ul class="nav nav-underline justify-content-center">
            <li class="nav-item">
              <a class="nav-link formulario-link" href="/cadastro.php">Cadastrar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link formulario-link active" aria-current="page" href="/edicao.php">Editar</a>
            </li>
            <li class="nav-item">
              <a class="nav-link formulario-link" href="/remocao.php">Remover</a>
            </li>
          </ul>
          <div class="card shadow-sm p-4">
            <h1 class="h4 mb-4 text-center">Editar Curso</h1>

            <form id="form-edicao-curso">
              <div class="mb-3">
                <label for="select-cursos-edicao" class="form-label">Curso</label>
                <select
                  class="form-select"
                  id="select-cursos-edicao"
                  name="select-cursos-edicao"
                  aria-placeholder="Curso a ser editado"
                ></select>
              </div>

              <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" id="nome" name="nome" class="form-control" required />
              </div>

              <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea id="descricao" name="descricao" class="form-control" rows="3" required></textarea>
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

              <button type="submit" class="btn btn-primary w-100">Editar Curso</button>
            </form>

            <div id="msg-edicao" class="alert alert-success mt-3 d-none" role="alert"></div>

            <p class="text-center mt-4">
              <a href="index.html" class="text-decoration-none">Voltar ao site principal</a>
            </p>
          </div>
        </div>
      </div>
    </div>

    <script src="js/edicao.js" type="module"></script>
  </body>
</html>
