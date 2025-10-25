const LISTA_ID = "lista-cursos";
const DATA_PATH = "data/cursos.json";

async function lerDados() {
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

function criarCardCurso(curso) {
    return `
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">${curso.titulo}</h5>
                    <span class="badge bg-primary me-2">${curso.categoria}</span>
                    <span class="badge ${curso.preco === 'Gratuito' ? 'bg-success' : 'bg-warning'}">${curso.preco}</span>
                    <p class="card-text mt-3">${curso.descricao}</p>
                    <a href="${curso.link}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Acessar Curso</a>
                </div>
            </div>
        </div>
    `;
}

function renderizarCursos(listaCursos) {
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

async function iniciarAplicacao() {
    console.log("Iniciando carregamento de cursos...");
    
    const cursosCarregados = await lerDados();

    if (!cursosCarregados || cursosCarregados.length === 0) {
        console.log("Nenhum curso encontrado ou erro de carregamento.");
        adicionarCards([]);
        return;
    }

    console.log(`Cursos carregados com sucesso: ${cursosCarregados.length}`);
    
    // Armazena os dados globalmente (útil para a filtragem)
    window.listaCursosGlobal = cursosCarregados;
    
    // Renderiza os cards dos cursos
    renderizarCursos(cursosCarregados);
    
    // TODO: função que configura os Event Listeners da barra de busca
    // (busca e filtragem de cursos)
}

document.addEventListener('DOMContentLoaded', iniciarAplicacao);