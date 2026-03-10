import { renderizarCursos, renderizarCategorias, renderizarPlaceholders } from "./cursos-render.js";
import { carregarCursos } from "./cursos-data.js";
import { configurarFiltros } from "./cursos-filtros.js";

/**
 * Função principal para carregar os dados e configurar a interface.
 */
async function iniciarAplicacao() {
  let timeoutPlaceholders = setTimeout(() => {
    renderizarPlaceholders();
  }, 100);

  try {
  
    const cursos = await carregarCursos();

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

document.addEventListener("DOMContentLoaded", iniciarAplicacao);