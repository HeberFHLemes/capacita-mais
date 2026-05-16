import {
  renderizarCursos,
  renderizarCategorias,
  renderizarPlaceholders,
} from "../ui/cursos-render.js";
import { buscarCursos } from "../api/cursos-api-client.js";
import { configurarFiltros } from "../filters/cursos-filtros.js";

/**
 * Função principal para carregar os dados e configurar a interface.
 */
async function apresentarCatalogo() {
  let timeoutPlaceholders = setTimeout(() => {
    renderizarPlaceholders();
  }, 100);

  try {
    const cursos = await buscarCursos();

    clearTimeout(timeoutPlaceholders);

    renderizarCategorias(cursos);
    configurarFiltros(cursos);
    renderizarCursos(cursos);
  } catch (e) {
    console.error(e);
    clearTimeout(timeoutPlaceholders);
    renderizarCursos([]);
  }
}

document.addEventListener("DOMContentLoaded", apresentarCatalogo);
