import { renderizarCursos, renderizarCategorias } from "./cursos-render.js";
import { carregarCursos } from "./cursos-data.js";
import { configurarFiltros } from "./cursos-filtros.js";

/**
 * Função principal para carregar os dados e configurar a interface.
 */
async function iniciarAplicacao() {
  console.log("Iniciando carregamento de cursos...");

  const cursosCarregados = await carregarCursos();

  if (!cursosCarregados || cursosCarregados.length === 0) {
    console.log("Nenhum curso encontrado ou erro de carregamento.");
  } else {
    console.log(`Cursos carregados com sucesso: ${cursosCarregados.length}`);
  }

  renderizarCursos(cursosCarregados);

  renderizarCategorias(cursosCarregados);

  configurarFiltros(cursosCarregados);
}

document.addEventListener("DOMContentLoaded", iniciarAplicacao);
