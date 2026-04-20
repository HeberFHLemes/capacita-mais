<!doctype html>
<html lang="pt-BR">
  <?php
    require __DIR__ . '/components/head.php';
    gerarHead("Capacita+ | Cursos")
  ?>
  <body class="d-flex flex-column min-vh-100">
    <?php 
      require __DIR__ . '/components/nav.php';
      gerarNav();
    ?>

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
                      name="radio-custo"
                      value="Gratuito"
                      id="radio-gratuito"
                    />
                    <label class="form-check-label" for="radio-gratuito">Gratuito</label>
                  </div>
                  <div class="form-check">
                    <input
                      class="form-check-input filtro-custo"
                      type="radio"
                      name="radio-custo"
                      value="Pago"
                      id="radio-pago"
                    />
                    <label class="form-check-label" for="radio-pago">Pago</label>
                  </div>
                  <div class="form-check">
                    <input
                      class="form-check-input filtro-custo"
                      type="radio"
                      name="radio-custo"
                      value="Todos"
                      id="radio-todos"
                      checked
                    />
                    <label class="form-check-label" for="radio-todos">Todos</label>
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

    <?php require __DIR__ . '/components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script type="module" src="/js/cursos.js"></script>
  </body>
</html>
