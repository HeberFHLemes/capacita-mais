const LISTA_ID = "lista-cursos";

function criarCardCurso(curso) {
  return `
        <div class="col-md-6 col-lg-4 mb-4 w-auto-100">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                  <h5 class="card-title card-curso-titulo">${curso.titulo}</h5>
                  <span class="badge bg-primary me-2">${curso.categoria}</span>
                  <span class="badge ${curso.preco === "Gratuito" ? "bg-success" : "bg-danger"}">
                    ${curso.preco}
                  </span>
                  <p class="card-text card-curso-descricao mt-3">${curso.descricao}</p>
                </div>
                <div class="card-footer text-center bg-white border-0">
                  <a href="${curso.link}" target="_blank" rel="noreferrer" class="btn btn-sm btn-outline-primary w-100">
                    Acessar Curso <i class="bi bi-box-arrow-up-right"></i>
                  </a>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item text-center">${curso.plataforma}</li>
                </ul>
            </div>
        </div>
    `;
}

export function renderizarCursos(listaCursos) {
  const container = document.getElementById(LISTA_ID);

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

  content += `</div>`;
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
