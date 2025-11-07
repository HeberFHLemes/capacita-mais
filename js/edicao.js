import { popularSelectDeCursos } from "./cursos.js";

/**
 * Preenche os campos do formulário com os dados do curso selecionado.
 * @param {Array<Object>} cursos 
 */
function addSelectChangeListener(cursos) {
  const select = document.getElementById("select-cursos-edicao");
  select.addEventListener("change", function () {
      if (!this.value) return;

      const cursoSelecionado = cursos.find((curso) => curso.titulo === this.value);
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

document.addEventListener("DOMContentLoaded", () => {
  popularSelectDeCursos("select-cursos-edicao", addSelectChangeListener);
});

document.getElementById("form-edicao-curso").addEventListener("submit", function (e) {
  e.preventDefault();

  if (!document.getElementById("select-cursos-edicao").value) {
    alert("Por favor, selecione um curso para editar.");
    return;
  }

  const titulo = document.getElementById("titulo").value;
  const msg = document.getElementById("msg-edicao");
  msg.textContent = `Curso "${titulo}" editado com sucesso!`;
  msg.classList.remove("d-none");

  this.reset();
});
