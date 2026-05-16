/*
 * Funções centralizando a lógica de comunicação com a API.
 *
 * Busca    - GET /api/cursos
 * Cadastro - POST /api/cursos
 * Edição   - PUT /api/cursos?id=[ID]
 * Remoção  - DELETE /api/cursos?id=[ID]
 */
const API_PATH = "/api/cursos";

export async function buscarCursos() {
  try {
    return await enviarRequest("GET", null);
  } catch (error) {
    return [];
  }
}

export async function cadastrarCurso(curso) {
  return await enviarRequest("POST", curso);
}

export async function editarCurso(cursoId, curso) {
  const apiUrl = montarUrlComId(cursoId);
  return await enviarRequest("PUT", curso, apiUrl);
}

export async function removerCurso(cursoId) {
  const apiUrl = montarUrlComId(cursoId);
  return await enviarRequest("DELETE", null, apiUrl);
}

function montarUrlComId(cursoId) {
  return `${API_PATH}?id=${cursoId}`;
}

/**
 * Envia a requisição para a URL da API definida,
 * com método HTTP e corpo da requisição.
 *
 * Retorna o JSON da resposta ou as informações do erro/exceção,
 * como status e mensagem.
 *
 * @param {*} method
 * @param {*} body
 * @param {*} apiPath
 * @returns Resposta em JSON ou informações do erro.
 */
async function enviarRequest(method, body, apiPath = API_PATH) {
  try {
    const options = {
      method,
    };

    if (body) {
      options.body = JSON.stringify(body);
      options.headers = {
        "Content-Type":"application/json; charset=UTF-8",
      };
    }

    const response = await fetch(apiPath, options);

    let data = null;

    if (response.status !== 204) {
      data = await response.json();
    }

    if (!response.ok) {
      throw {
        status: response.status,
        mensagem: data?.erro || "Erro na requisição",
      };
    }

    return data;
  } catch (erro) {
    console.error(erro);
    throw erro;
  }
}
