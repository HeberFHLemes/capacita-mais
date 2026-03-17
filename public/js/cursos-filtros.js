import { renderizarCursos } from "./cursos-render.js";

const BOTAO_LIMPAR_ID = "btn-limpar-filtros";
const CAMPO_BUSCA_ID = "campo-busca";

/**
 * Configura todos os Event Listeners para busca e filtros.
 * @param {Array} listaCursos - A lista de cursos obtida ao ler os dados.
 */
export function configurarFiltros(listaCursos) {
  const aplicarFiltrosERenderizar = () => {
    const resultados = filtrarCursos(listaCursos);
    renderizarCursos(resultados);
  };

  // keyup na barra de busca
  document.getElementById(CAMPO_BUSCA_ID).addEventListener("keyup", aplicarFiltrosERenderizar);

  // change para os checkboxes e radios de custo
  document.querySelectorAll('input[name="radioCusto"]').forEach((controle) => {
    controle.addEventListener("change", aplicarFiltrosERenderizar);
  });
  // checkboxes de categoria
  document.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
    checkbox.addEventListener("change", aplicarFiltrosERenderizar);
  });

  // click para o botão de limpar filtros
  document.getElementById(BOTAO_LIMPAR_ID).addEventListener("click", () => {
    limparFiltros();
    aplicarFiltrosERenderizar();
  });
}

/**
 * Aplica todos os filtros e busca sobre a lista completa.
 * Lê o estado atual dos inputs (busca, checkboxes, radio buttons) do DOM.
 * @param {Array} listaCompleta - O array completo de cursos.
 * @returns {Array} A lista de cursos após a aplicação de todos os filtros.
 */
export function filtrarCursos(listaCompleta) {
  let resultados = listaCompleta;

  // faz a busca na lista de cursos
  const busca = document.getElementById(CAMPO_BUSCA_ID).value.toLowerCase();
  if (busca) {
    resultados = resultados.filter(
      (curso) =>
        curso.nome.toLowerCase().includes(busca) ||
        curso.descricao.toLowerCase().includes(busca) ||
        (curso.categoria && curso.categoria.toLowerCase().includes(busca))
    );
  }

  // filtra por qual radio de custo está selecionado
  const custoSelecionado = document.querySelector('input[name="radioCusto"]:checked');
  if (custoSelecionado && custoSelecionado.value !== "Todos") {
    const isGratuito = custoSelecionado.value === "Gratuito";

    resultados = resultados.filter(
      (curso) => (curso.gratuito && isGratuito) || (!curso.gratuito && !isGratuito)
    );
  }

  // filtra por todos os checkboxes de categoria selecionados
  const categoriasSelecionadas = Array.from(
    document.querySelectorAll('input[type="checkbox"]:checked')
  ).map((checkbox) => checkbox.value);

  if (categoriasSelecionadas.length > 0) {
    resultados = resultados.filter((curso) => categoriasSelecionadas.includes(curso.categoria));
  }

  return resultados;
}

/**
 * Limpa todos os controles de filtro no DOM.
 */
export function limparFiltros() {
  // Limpa o campo de busca
  document.getElementById(CAMPO_BUSCA_ID).value = "";

  // Reseta o radio de custo para "Todos"
  document.getElementById("radioTodos").checked = true;

  // Limpa os checkboxes de categoria
  const categorias = document.querySelectorAll('input[type="checkbox"]');
  categorias.forEach((checkbox) => {
    checkbox.checked = false;
  });
}
