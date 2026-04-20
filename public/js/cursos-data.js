const DATA_PATH = "/api/cursos";

let cursosEmCache = null;

/**
 * Envia uma requisição para o back-end e retorna a lista de cursos obtida.
 * @returns {Promise<Array>} Retorna a lista de cursos ou um array vazio em caso de erro.
 */
export async function carregarCursos() {
  try {
    if (!cursosEmCache) {
      const response = await fetch(DATA_PATH, { method: "GET" });

      if (!response.ok) {
        throw new Error(`Erro HTTP - Status: ${response.status}`);
      }
      cursosEmCache = await response.json();
    }
    return cursosEmCache;
  } catch (error) {
    console.error("Erro na requisição: ", error);
    return [];
  }
}
