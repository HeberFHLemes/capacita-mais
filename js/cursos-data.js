const DATA_PATH = "data/cursos.json";

let cursosEmCache = null;

/**
 * Lê os dados do arquivo JSON usando fetch.
 * @returns {Promise<Array>} Retorna a lista de cursos ou um array vazio em caso de erro.
 */
export async function carregarCursos() {
  try {
    if (!cursosEmCache) {
      const response = await fetch(DATA_PATH);

      if (!response.ok) {
        throw new Error(`Erro HTTP - Status: ${response.status}`);
      }
      cursosEmCache = await response.json();
    }
    return cursosEmCache;
  } catch (error) {
    console.error("Erro ao processar dados do arquivo JSON:", error);
    return [];
  }
}