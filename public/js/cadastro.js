import CursosFormHandler from "./cursos-form-handler.js";

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("form-cadastro-curso");
  if (form) {
    const handler = new CursosFormHandler();
    form.addEventListener("submit", (e) => handler.cadastrar(e));
  }
});
