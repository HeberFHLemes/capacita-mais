import { popularSelectDeCursos } from "./cursos-render.js";
import { carregarCursos } from "./cursos-data.js";
import CursosFormHandler from "./cursos-form-handler.js";

document.addEventListener("DOMContentLoaded", async () => {
  const cursos = await carregarCursos();
  popularSelectDeCursos("select-cursos-edicao", cursos, addSelectChangeListener);

  const form = document.getElementById("form-edicao-curso");
  if (form) {
    const handler = new CursosFormHandler();
    form.addEventListener("submit", (e) => handler.editar(e));
  }
});

/**
 * Preenche os campos do formulário com os dados do curso selecionado.
 * @param {Array<Object>} cursos
 */
function addSelectChangeListener(cursos) {
  const select = document.getElementById("select-cursos-edicao");
  select.addEventListener("change", function () {
    if (!this.value) return;

    // const cursoSelecionado = cursos.find((curso) => curso.titulo === this.value);
    const cursoSelecionado = cursos.find(
      (curso) => curso.id == this.value
    );
    if (cursoSelecionado) {
      document.getElementById("titulo").value = cursoSelecionado.titulo;
      document.getElementById("descricao").value = cursoSelecionado.descricao;
      document.getElementById("categoria").value = cursoSelecionado.categoria;
      document.getElementById("plataforma").value = cursoSelecionado.plataforma;
      document.getElementById("preco").value = cursoSelecionado.preco;
      document.getElementById("link").value = cursoSelecionado.link;
    }
  });
}
