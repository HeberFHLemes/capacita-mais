import { lerDados } from "./cursos.js";

async function popularSelectDeCursos(idSelect, callback) {
  const select = document.getElementById(idSelect);

  const cursos = await lerDados();
  select.innerHTML = "";
  const placeholder = document.createElement("option");
  placeholder.value = "";
  placeholder.textContent = "Selecione um curso";
  placeholder.selected = true;
  placeholder.disabled = true;
  select.appendChild(placeholder);

  cursos.forEach((curso) => {
    const option = document.createElement("option");
    option.value = curso.titulo;
    option.textContent = curso.titulo;
    select.appendChild(option);
  });
  if (callback) callback(cursos);
}

document.addEventListener("DOMContentLoaded", async () => {
  await popularSelectDeCursos("select-cursos-remocao");
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

  this.reset();
});