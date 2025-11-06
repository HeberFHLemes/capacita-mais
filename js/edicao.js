import { lerDados } from "./cursos.js";

/**
 * Popula o formulário de edição com os dados do curso selecionado.
 * @returns {void}
 */
document.addEventListener("DOMContentLoaded", function () {
  const select = document.getElementById("curso-selecionado");

  lerDados().then((cursos) => {
    cursos.forEach((curso) => {
      const option = document.createElement("option");
      option.value = curso.titulo;
      option.textContent = curso.titulo;
      select.appendChild(option);
    });

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
  });
});

document.getElementById("form-edicao-curso").addEventListener("submit", function (e) {
  e.preventDefault();

  if (!document.getElementById("curso-selecionado").value) {
    alert("Por favor, selecione um curso para editar.");
    return;
  }

  const titulo = document.getElementById("titulo").value;
  const msg = document.getElementById("msg");
  msg.textContent = `Curso "${titulo}" editado com sucesso!`;
  msg.classList.remove("d-none");

  this.reset();
});
