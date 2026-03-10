import { popularSelectDeCursos } from "./cursos-render.js";
import { carregarCursos } from "./cursos-data.js";
import CursosFormHandler from "./cursos-form-handler.js";

document.addEventListener("DOMContentLoaded", async () => {
  const cursos = await carregarCursos();
  popularSelectDeCursos("select-cursos-remocao", cursos);

  const form = document.getElementById("form-remocao-curso");
  if (form) {
    const handler = new CursosFormHandler();
    form.addEventListener("submit", (e) => handler.remover(e));
  }
});
