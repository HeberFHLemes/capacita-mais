import { popularSelectDeCursos } from "../ui/cursos-render.js";
import { buscarCursos, removerCurso } from "../api/cursos-api-client.js";
import { mostrarMensagem } from "../forms/cursos-form-utils.js";

document.addEventListener("DOMContentLoaded", async () => {
  const cursos = await buscarCursos();
  popularSelectDeCursos("select-cursos-remocao", cursos);

  const formElement = document.getElementById("form-remocao-curso");
  if (formElement) {
    formElement.addEventListener("submit", handleRemoverCurso);
  }
});

async function handleRemoverCurso(event) {
  event.preventDefault();

  const select = document.getElementById("select-cursos-remocao");

  const cursoId = select.value;

  if (!cursoId) {
    mostrarMensagem("Por favor, selecione um curso válido.", "msg-remocao", "danger");
    return;
  }

  const form = event.target;

  const btn = form.querySelector("button[type='submit']");
  btn.disabled = true;

  try {
    await removerCurso(cursoId);

    select.remove(select.selectedIndex);

    mostrarMensagem("Curso removido com sucesso!", "msg-remocao");
    form.reset();
  } catch (erro) {
    mostrarMensagem("Erro ao remover curso.", "msg-remocao", "danger");
    console.error(erro);
  } finally {
    btn.disabled = false;
  }
}