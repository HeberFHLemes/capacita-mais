import { cadastrarCurso } from "../api/cursos-api-client.js";
import { montarCursoDoForm, mostrarMensagem } from "../forms/cursos-form-utils.js";

document.addEventListener("DOMContentLoaded", () => {
  const formElement = document.getElementById("form-cadastro-curso");
  if (formElement) {
    formElement.addEventListener("submit", handleCadastrarCurso);
  }
});

async function handleCadastrarCurso(event) {
  event.preventDefault();

  const form = event.target;
  const formData = new FormData(form);

  const curso = montarCursoDoForm(formData);

  const btn = form.querySelector("button[type='submit']");
  btn.disabled = true;

  try {
    await cadastrarCurso(curso);

    mostrarMensagem("Curso cadastrado com sucesso!", "msg");
    form.reset();
  } catch (erro) {
    if (erro.status === 409) {
      mostrarMensagem(erro.mensagem, "msg", "warning");
      return;
    }
    mostrarMensagem("Erro ao cadastrar curso.", "msg", "danger");
  } finally {
    btn.disabled = false;
  }
}