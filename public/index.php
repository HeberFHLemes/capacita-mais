<!doctype html>
<html lang="pt-BR">
  <?php
    require __DIR__ . '/components/head.php';
    gerarHead("Capacita+")
  ?>
  <body class="d-flex flex-column min-vh-100">
    <?php 
      require __DIR__ . '/components/nav.php';
      gerarNav();
    ?>

    <header class="hero-section">
      <div class="container text-center">
        <h1 class="display-4 fw-bolder text-dark">
          Capacite-se para o Futuro.
          <br />
          <span class="text-primary">Comece por Aqui.</span>
        </h1>
        <p class="lead mt-4 text-muted">
          Encontre cursos gratuitos e acessíveis para acelerar sua carreira no mercado de
          tecnologia.
        </p>
        <a
          href="cursos.php"
          class="btn btn-lg btn-success mt-4 shadow-lg"
          data-cy="btn-explorar-cursos"
        >
          Explorar cursos &nbsp; <i class="bi bi-search"></i>
        </a>
      </div>
    </header>

    <section class="py-5">
      <div class="container">
        <h2 class="text-center mb-5 fw-bold text-underline">Nossa Missão</h2>
        <div class="row">
          <div class="col-md-4 mb-4">
            <div class="card border-0 shadow impact-card p-3">
              <div class="card-body">
                <i class="bi bi-laptop"></i>
                <h3 class="card-title fw-bold h5">Foco em Home Office</h3>
                <p class="card-text card-missao-text text-muted">
                  Aprenda as habilidades digitais essenciais para conquistar e prosperar em vagas
                  remotas.
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card border-0 shadow impact-card p-3">
              <div class="card-body">
                <i class="bi bi-person-workspace"></i>
                <h3 class="card-title fw-bold h5">Nova Carreira</h3>
                <p class="card-text card-missao-text text-muted">
                  Facilitamos sua transição de área, do primeiro emprego à atualização profissional.
                </p>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-4">
            <div class="card border-0 shadow impact-card p-3">
              <div class="card-body">
                <i class="bi bi-people"></i>
                <h3 class="card-title fw-bold h5">Acesso Gratuito</h3>
                <p class="card-text card-missao-text text-muted">
                  Comprometimento em catalogar e destacar o melhor do conteúdo educacional gratuito
                  e de qualidade.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <?php require __DIR__ . '/components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
