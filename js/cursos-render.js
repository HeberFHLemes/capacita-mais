const LISTA_ID = "lista-cursos";

function criarCardCurso(curso) {
  const isGratuito = curso.preco === "Gratuito";
  const badgePrecoClass = isGratuito ? "bg-success" : "bg-danger";

  return `
    <article class="col-12 col-md-6 col-lg-4 mb-4">
      <div class="card h-100 shadow-sm card-curso">
        <div class="card-body d-flex flex-column">
          <h2 class="card-title h5 fw-bold">
            ${curso.titulo}
          </h2>
          <div class="mb-2">
            <span class="badge bg-primary">${curso.categoria}</span>
            <span class="badge ${badgePrecoClass}">
              ${curso.preco}
            </span>
          </div>
          <p class="card-text text-secondary flex-grow-1 card-curso-descricao">
            ${curso.descricao}
          </p>
          <small class="text-muted mb-3">
            <i class="bi bi-display me-1"></i>
            ${curso.plataforma}
          </small>
          <a href="${curso.link}" 
            target="_blank"
            rel="noopener"
            class="btn btn-outline-primary w-100">
            Acessar Curso
            <i class="bi bi-box-arrow-up-right ms-2"></i>
          </a>
        </div>
      </div>
    </article>
  `;
}

export function renderizarCursos(listaCursos) {
  const container = document.getElementById(LISTA_ID);

  if (!container) {
    console.error(`Elemento com ID ${LISTA_ID} não encontrado.`);
    return;
  }

  let content = "";

  if (listaCursos.length === 0) {
    content += `<div class="col-12"><p class="alert alert-info">Nenhum curso disponível no momento.</p></div>`;
  } else {
    listaCursos.forEach((curso) => {
      content += criarCardCurso(curso);
    });
  }

  container.innerHTML = content;
}

export function renderizarCategorias(cursos) {
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
 * Ao demorar para a resposta ser apresentada, 
 * carregam-se esqueletos de cards.
 */
export function renderizarPlaceholders(qtd = 6) {
  const container = document.getElementById(LISTA_ID);

  container.innerHTML = Array.from({ length: qtd })
    .map(() => criarCardPlaceholder())
    .join("");
}

export function criarCardPlaceholder() {
  return `
    <div class="col-md-6 col-lg-4 mb-4 w-auto-100">
      <div class="card shadow-sm h-100">
        <div class="card-body">
          <h5 class="card-title card-curso-titulo placeholder-glow">
            <span class="placeholder col-8"></span>
          </h5>
          <div class="placeholder-glow">
            <span class="col-6 placeholder me-2"></span>
            <span class="col-4 placeholder"></span>
          </div>
          <p class="card-text card-curso-descricao mt-3 placeholder-glow">
            <span class="placeholder col-12"></span>
            <span class="placeholder col-12"></span>
            <span class="placeholder col-6"></span>
          </p>
        </div>
        <div class="card-footer text-center bg-white border-0 placeholder-glow">
          <span class="placeholder col-8 btn btn-sm btn-outline-primary w-100"></span>
        </div>
        <ul class="list-group list-group-flush ">
          <li class="list-group-item text-center placeholder-glow">
            <span class="placeholder col-6"></span>
          </li>
        </ul>
      </div>
    </div>
  `;
}

/**
 * Popula um select com os cursos disponíveis como options.
 * @param {string} idSelect - O ID do elemento select a ser populado.
 * @param {function} [callback] - Função opcional a ser chamada após popular o select, 
 * que tenha como parametro a lista de cursos.
 * @returns {void}
 */
export async function popularSelectDeCursos(idSelect, cursos, callback) {
  const select = document.getElementById(idSelect);

  // const cursos = await lerDados();

  select.innerHTML = "";
  if (cursos.length == 0) {
    select.appendChild(new Option("Nenhum curso encontrado", "", true, false));
  } else {
    let placeholder = new Option("Selecione o curso", "", true, false);
    placeholder.disabled = true;
    placeholder.hidden = true;
    placeholder.selected = true;
    select.appendChild(placeholder);

    cursos.forEach((curso) => {
      const option = document.createElement("option");
      option.value = curso.id;
      option.textContent = curso.titulo;
      select.appendChild(option);
    });
  }
  if (callback) callback(cursos);
}

/**
 * Gera o HTML para um checkbox dinâmico,
 * com base nos parâmetros fornecidos.
 * @param {string} label
 * @param {string} id
 * @param {string} value
 * @param {Array<string>} divClasses
 * @param {Array<string>} inputClasses
 * @param {Array<string>} labelClasses
 * @param {boolean} checked default false
 * @returns
 */
function gerarCheckbox(
  label,
  id,
  value,
  divClasses = [],
  inputClasses = [],
  labelClasses = [],
  checked = false
) {
  const div = document.createElement("div");
  if (divClasses.length) div.classList.add(...divClasses);

  const input = document.createElement("input");
  input.type = "checkbox";
  input.id = id;
  input.value = value;
  if (inputClasses.length) input.classList.add(...inputClasses);
  if (checked) input.checked = true;

  const labelEl = document.createElement("label");
  if (labelClasses.length) labelEl.classList.add(...labelClasses);
  labelEl.setAttribute("for", id);
  labelEl.textContent = label;

  div.append(input, labelEl);
  return div;
}
