import { popularSelectDeCursos } from "./cursos.js";

document.addEventListener("DOMContentLoaded", () => {
  popularSelectDeCursos("select-cursos-remocao");
});

document.getElementById("form-remocao-curso").addEventListener("submit", function (e) {
  e.preventDefault();

  const select = document.getElementById("select-cursos-remocao");
  const curso = select.value;
  if (!curso) {
    alert("Por favor, selecione um curso para remover.");
    return;
  }

  select.remove(select.selectedIndex);

  const msg = document.getElementById("msg-remocao");
  msg.textContent = `Curso "${curso}" removido com sucesso!`;
  msg.classList.remove("d-none");
  msg.scrollIntoView({ behavior: "smooth", block: "center" });

  this.reset();
});
