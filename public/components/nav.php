<?php
/**
 * Criando componentes HTML com PHP
 * 
 * Gera uma barra de navegação, com base em um array associativo `$paginas`,
 * contendo `$label` (nome a ser apresentado) e `url`.
 * 
 * @link https://gist.github.com/iampava/6e7d3698f5c15d756bdd429b623c0a38
 */
function gerarNav(?array $paginas=null): void {
    $paginaAtual = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    if ($paginas === null) $paginas = [
        ['label' => 'Início', 'url' => '/index.php'],
        ['label' => 'Cursos', 'url' => '/cursos.php'],
        ['label' => 'Sobre Nós', 'url' => '/sobre.php'],
    ];
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="/">Capacita+</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Abrir menu de navegação"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php foreach ($paginas as $pagina): 
                    $isActive = $pagina['url'] === $paginaAtual;
                ?>
                <li class="nav-item">
                    <a class="nav-link fw-medium <?= $isActive ? 'active' : '' ?>" 
                        <?= $isActive ? 'aria-current="page"' : '' ?>
                        href="<?= $pagina['url'] ?>"
                    >
                        <?= $pagina['label'] ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>
<?php
}