<?php
    $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    function active($path, $url) {
        return $url === $path ? 'active' : '';
    }

    function aria($path, $url) {
        return $url === $path ? 'aria-current="page"' : '';
    }
?>
<nav>
    <div class="d-flex align-items-end mx-4 border-bottom">

        <ul class="nav nav-underline">
            <li class="nav-item">
                <a class="nav-link formulario-link <?= active('/cadastro', $url) ?>"
                   <?= aria('/cadastro', $url) ?>
                   href="/cadastro">
                   <i class="bi bi-plus"></i> Cadastrar
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link formulario-link <?= active('/edicao', $url) ?>"
                   <?= aria('/edicao', $url) ?>
                   href="/edicao">
                   <i class="bi bi-pencil-square"></i> Editar
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link formulario-link <?= active('/remocao', $url) ?>"
                   <?= aria('/remocao', $url) ?>
                   href="/remocao">
                   <i class="bi bi-x"></i> Remover
                </a>
            </li>
        </ul>

        <div class="ms-auto">
            <a class="nav-link text-danger fw-semibold mb-2 logout-link"
                href="/logout">
                <i class="bi bi-box-arrow-right"></i> Sair
            </a>
        </div>

    </div>
</nav>