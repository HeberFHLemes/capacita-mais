import { gerarCheckbox } from "./utils.js";

const DATA_PATH = "data/cursos.json";

const LISTA_ID = "lista-cursos";
const CONTADOR_ID = "contador-cursos";
const BOTAO_LIMPAR_ID = "btn-limpar-filtros";
const CAMPO_BUSCA_ID = "campo-busca";

/**
 * Lê os dados do arquivo JSON usando fetch.
 * @returns {Promise<Array>} Retorna a lista de cursos ou um array vazio em caso de erro.
 */
export async function lerDados() {
  try {
    const response = await fetch(DATA_PATH);

    if (!response.ok) {
      throw new Error(`Erro HTTP - Status: ${response.status}`);
    }
    return await response.json();
  } catch (error) {
    console.error("Erro ao processar dados do arquivo JSON:", error);
    return []; // Array vazio retornado caso haja erro
  }
}

/**
 * Gera o HTML para um card de curso.
 * @param {Object} curso - O objeto de dados do curso.
 * @returns {string} O HTML do card.
 */
function criarCardCurso(curso) {
  return `
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">${curso.titulo}</h5>
                    <span class="badge bg-primary me-2">${curso.categoria}</span>
                    <span class="badge ${curso.preco === "Gratuito" ? "bg-success" : "bg-warning"}">${curso.preco}</span>
                    <p class="card-text mt-3">${curso.descricao}</p>
                    <a href="${curso.link}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Acessar Curso</a>
                </div>
            </div>
        </div>
    `;
}

/**
 * Renderiza (substitui) a lista de cards no container principal.
 * @param {Array} listaCursos - A lista de cursos a ser exibida (filtrada ou completa).
 */
function renderizarCursos(listaCursos) {
  const container = document.getElementById(LISTA_ID);
  const contador = document.getElementById(CONTADOR_ID);

  if (!container) {
    console.error(`Elemento com ID ${LISTA_ID} não encontrado.`);
    return;
  }

  let content = `<div class="row">`;

  if (listaCursos.length === 0) {
    content += `<div class="col-12"><p class="alert alert-info">Nenhum curso disponível no momento.</p></div>`;
  } else {
    listaCursos.forEach((curso) => {
      content += criarCardCurso(curso);
    });
  }
  if (contador) contador.textContent = `${listaCursos.length} Cursos Encontrados`;

  content += `</div>`;
  container.innerHTML = content;
}

/**
 * Configura todos os Event Listeners para busca e filtros.
 */
function configurarFiltros() {
  const aplicarFiltrosERenderizar = () => {
    const resultados = filtrarCursos(listaCursosGlobal);
    renderizarCursos(resultados);
  };

  // keyup na barra de busca
  document.getElementById(CAMPO_BUSCA_ID).addEventListener("keyup", aplicarFiltrosERenderizar);

  // change para os checkboxes e radios
  // radios de custo
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
 * @param {Array} listaCompleta - O array completo de cursos (window.listaCursosGlobal).
 * @returns {Array} A lista de cursos após a aplicação de todos os filtros.
 */
function filtrarCursos(listaCompleta, termo) {
  let resultados = listaCompleta;

  // faz a busca na lista de cursos
  const busca = document.getElementById(CAMPO_BUSCA_ID).value.toLowerCase();
  if (busca) {
    resultados = resultados.filter(
      (curso) =>
        curso.titulo.toLowerCase().includes(busca) ||
        curso.descricao.toLowerCase().includes(busca) ||
        (curso.categoria && curso.categoria.toLowerCase().includes(busca))
    );
  }

  // filtra por qual radio de custo está selecionado
  const custoSelecionado = document.querySelector('input[name="radioCusto"]:checked');
  if (custoSelecionado && custoSelecionado.value !== "Todos") {
    const custoFiltro = custoSelecionado.value; // Gratuito || Pago

    resultados = resultados.filter(
      (curso) => curso.preco && curso.preco.toLowerCase() === custoFiltro.toLowerCase()
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
function limparFiltros() {
  // Limpa o campo de busca
  document.getElementById("campo-busca").value = "";

  // Reseta o radio de custo para "Todos"
  document.getElementById("radioTodos").checked = true;

  // Limpa os checkboxes de categoria
  const categorias = document.querySelectorAll('input[type="checkbox"]');
  categorias.forEach((checkbox) => {
    checkbox.checked = false;
  });
}

/**
 * Renderiza os filtros de categoria com base na lista de cursos.
 * @param {Array} cursos  O array completo de cursos
 */
function renderizarCategorias(cursos) {
  const categoriasUnicas = [...new Set(cursos.map((curso) => curso.categoria))];
  const containerCategorias = document.getElementById("filtros-categorias-div");

  categoriasUnicas.forEach((categoria) => {
    const checkboxCategoria = gerarCheckbox(
      categoria,
      `check${categoria.replace(/\s+/g, "")}`,
      categoria,
      ["form-check", "filtro-categoria"],
      ["form-check-input"],
      ["form-check-label"],
      false
    );
    containerCategorias.appendChild(checkboxCategoria);
  });
}

/**
 * Função principal assíncrona para carregar dados e configurar a interface.
 */
async function iniciarAplicacao() {
  console.log("Iniciando carregamento de cursos...");

  const cursosCarregados = await lerDados();

  if (!cursosCarregados || cursosCarregados.length === 0) {
    console.log("Nenhum curso encontrado ou erro de carregamento.");
  } else {
    console.log(`Cursos carregados com sucesso: ${cursosCarregados.length}`);
  }

  // Armazena os dados globalmente (útil para a filtragem)
  window.listaCursosGlobal = cursosCarregados;

  // Renderiza os cards dos cursos
  renderizarCursos(cursosCarregados);

  // Renderiza as categorias listadas para filtragem
  renderizarCategorias(cursosCarregados);

  // Configura os Event Listeners da busca e filtragem
  configurarFiltros();
}

document.addEventListener("DOMContentLoaded", iniciarAplicacao);
