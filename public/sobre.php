<!doctype html>
<html lang="pt-BR">
  <?php
    require __DIR__ . '/components/head.php';
    gerarHead("Capacita+ | Sobre Nós")
  ?>
  <body class="d-flex flex-column min-vh-100">
    <?php 
      require __DIR__ . '/components/nav.php';
      gerarNav();
    ?>

    <section class="py-4" id="sobre-section">
      <div class="container py-5">
        <h1 class="text-center mb-3 fw-bold text-underline">Sobre o Capacita+</h1>
        <h2 class="text-center mb-3 fw-semibold text-primary">
          Um portal livre de curadoria para cursos de capacitação
        </h2>
        <div id="sobre-section-text" class="mx-auto">
          <p class="mb-3">
            O objetivo do Capacita+ é reunir indicações de cursos gratuitos e plataformas de
            aprendizado.
          </p>
          <p class="mb-3">
            Nosso foco é em tecnologia, mas abrangemos também outras áreas de conhecimento.
          </p>
          <p class="mb-3">
            Somos, essencialmente, um portal de curadoria, isto é, não criamos cursos, mas
            organizamos, centralizamos e indicamos conteúdos de capacitação, sejam eles gratuitos ou
            acessíveis, para quem busca se atualizar profissionalmente.
          </p>
          <p class="mb-3 text-center">Sintam-se motivados a trilhar o caminho do conhecimento.</p>
          <p class="mb-3 fw-semibold text-end">Equipe do Capacita+</p>
        </div>
      </div>
    </section>

    <section class="py-4" id="contato-section" aria-label="Redes de contato do Capacita+">
      <div class="container">
        <h1 class="text-center mb-3 fw-bold text-underline">Fale conosco</h1>
        <p class="text-center mb-2 py-2">
          Entre em contato conosco por meio de uma das nossas redes de contato
        </p>
        <ul class="list-unstyled d-flex justify-content-center">
          <li>
            <a
              href="https://github.com/HeberFHLemes/capacita-mais/tree/gh-pages"
              target="_blank"
              rel="noreferrer"
              aria-label="GitHub"
            >
              <i class="bi bi-github fs-1"></i>
            </a>
          </li>
          <li>
            <span title="E-mail em breve disponível">
              <i class="bi bi-envelope-at fs-1"></i>
            </span>
          </li>
          <li>
            <a
              href="https://opencollective.com/"
              target="_blank"
              rel="noreferrer"
              aria-label="Open Collective"
            >
              <i class="bi bi-opencollective fs-1"></i>
            </a>
          </li>
        </ul>
      </div>
    </section>

    <?php require __DIR__ . '/components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
