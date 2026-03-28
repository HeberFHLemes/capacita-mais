import { renderizarCursos } from "./cursos-render.js";

const BOTAO_LIMPAR_ID = "btn-limpar-filtros";
const CAMPO_BUSCA_ID = "campo-busca";
const RADIO_TODOS = "radio-todos";

/**
 * Configura todos os Event Listeners para busca e filtros.
 * @param {Array} listaCursos - A lista de cursos obtida ao ler os dados.
 */
export function configurarFiltros(listaCursos) {
  const aplicarFiltrosERenderizar = () => {
    const filtros = lerFiltrosDoDOM();
    const resultados = filtrarCursos(listaCursos, filtros);
    renderizarCursos(resultados);
  };

  // keyup na barra de busca
  document.getElementById(CAMPO_BUSCA_ID)
    .addEventListener("keyup", aplicarFiltrosERenderizar);

  // change para os radios de custo
  document.querySelectorAll('input[type="radio"]').forEach((controle) => {
    controle.addEventListener("change", aplicarFiltrosERenderizar);
  });

  // change para os checkboxes de categoria
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
 * Lê os filtros do DOM.
 * @returns {{ busca: string, custo: string|null, categorias: string[] }}
 */
function lerFiltrosDoDOM() {
  const busca = document.getElementById(CAMPO_BUSCA_ID).value.toLowerCase();

  const custoChecked = document.querySelector('input[type="radio"]:checked');
  const custo = custoChecked?.value ?? null;

  const categorias = Array.from(
    document.querySelectorAll('input[type="checkbox"]:checked')
  ).map((cb) => cb.value);

  return { busca, custo, categorias };
}

/**
 * Filtra a lista de cursos com base nos filtros fornecidos.
 * @param {Array} listaCompleta
 * @param {{ busca: string, custo: string|null, categorias: string[] }} filtros
 * @returns {Array}
 */
function filtrarCursos(listaCompleta, { busca, custo, categorias }) {
  let resultados = listaCompleta;

  if (busca) {
    resultados = resultados.filter(
      (curso) =>
        curso.nome.toLowerCase().includes(busca) ||
        curso.descricao.toLowerCase().includes(busca) ||
        (curso.categoria && curso.categoria.toLowerCase().includes(busca))
    );
  }

  if (custo && custo !== "Todos") {
    const isGratuito = custo === "Gratuito";
    resultados = resultados.filter(
      (curso) => curso.gratuito === isGratuito
    );
  }

  if (categorias.length > 0) {
    resultados = resultados.filter((curso) => categorias.includes(curso.categoria));
  }

  return resultados;
}

/**
 * Limpa todos os controles de filtro no DOM.
 */
function limparFiltros() {
  // Limpa o campo de busca
  document.getElementById(CAMPO_BUSCA_ID).value = "";

  // Reseta o radio de custo para "Todos"
  document.getElementById(RADIO_TODOS).checked = true;

  // Limpa os checkboxes de categoria
  document.querySelectorAll('input[type="checkbox"]').forEach((cb) => {
    cb.checked = false;
  });
}
