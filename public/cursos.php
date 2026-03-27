<!doctype html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Capacita+ | Cursos</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="/assets/favicon/site.webmanifest">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap"
    />
    <link rel="stylesheet" href="/css/styles.css" />
  </head>
  <body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
      <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="index.php"> Capacita+ </a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link fw-medium" href="index.php">Início</a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-medium active" aria-current="page" href="cursos.php">Cursos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-medium" href="sobre.php">Sobre Nós</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <header>
      <h1 id="cursos-header" class="text-center mt-4 text-underline pt-4">Cursos disponíveis</h1>
    </header>

    <section id="cursos-section">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-4 mb-4">
            <aside class="sticky-lg-top" style="top: 80px; z-index: 1000">
              <!-- Barra de pesquisa -->
              <label for="campo-busca" class="form-label fw-bold">Pesquisa</label>
              <input
                type="search"
                id="campo-busca"
                class="form-control mb-3 shadow-sm"
                placeholder="Pesquisar curso por palavra-chave"
              />
              <!-- Filtro por custo -->
              <div class="card p-3 mb-3 shadow-sm">
                <fieldset class="border-0 m-0 p-0">
                  <legend class="fw-bold mb-3 h4">Custo</legend>
                  <div class="form-check">
                    <input
                      class="form-check-input filtro-custo"
                      type="radio"
                      name="radioCusto"
                      value="Gratuito"
                      id="radioGratuito"
                    />
                    <label class="form-check-label" for="radioGratuito">Gratuito</label>
                  </div>
                  <div class="form-check">
                    <input
                      class="form-check-input filtro-custo"
                      type="radio"
                      name="radioCusto"
                      value="Pago"
                      id="radioPago"
                    />
                    <label class="form-check-label" for="radioPago">Pago</label>
                  </div>
                  <div class="form-check">
                    <input
                      class="form-check-input filtro-custo"
                      type="radio"
                      name="radioCusto"
                      value="Todos"
                      id="radioTodos"
                      checked
                    />
                    <label class="form-check-label" for="radioTodos">Todos</label>
                  </div>
                </fieldset>
              </div>
              <!-- Filtro por categoria -->
              <fieldset class="card p-3 shadow-sm" id="filtros-categorias-div">
                <legend class="fw-bold mb-3 h4">Categoria</legend>
              </fieldset>
              <button id="btn-limpar-filtros" class="btn btn-outline-dark btn-sm mt-3 w-100">
                Limpar Filtros
              </button>
            </aside>
          </div>

          <div class="col-lg-9 col-md-8 mt-3 py-3">
            <div id="lista-cursos" class="row align-items-stretch"></div>
          </div>
        </div>
      </div>
    </section>

    <footer class="bg-dark text-white py-4 mt-auto border-top border-secondary-subtle">
      <div class="container text-center">
        <p class="mb-0">&copy; 2026 Capacita+. Todos os direitos reservados.</p>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script type="module" src="/js/cursos.js"></script>
  </body>
</html>
