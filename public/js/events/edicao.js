import { popularSelectDeCursos } from "../ui/cursos-render.js";
import { buscarCursos, editarCurso } from "../api/cursos-api-client.js";
import { montarCursoDoForm, mostrarMensagem } from "../forms/cursos-form-utils.js";

document.addEventListener("DOMContentLoaded", async () => {
  const cursos = await buscarCursos();
  popularSelectDeCursos("select-cursos-edicao", cursos, addSelectChangeListener);

  const formElement = document.getElementById("form-edicao-curso");
  if (formElement) {
    formElement.addEventListener("submit", handleEditarCurso);
  }
});

async function handleEditarCurso(event) {
  event.preventDefault();

  const select = document.getElementById("select-cursos-edicao");
  
  const cursoId = select.value;

  if (!cursoId) {
    mostrarMensagem("Por favor, selecione um curso válido.", "msg-edicao", "danger");
    return;
  }
  
  const form = event.target;
  const formData = new FormData(form);
  
  const curso = montarCursoDoForm(formData);

  const btn = form.querySelector("button[type='submit']");
  btn.disabled = true;

  try {
    const response = await editarCurso(cursoId, curso);

    if (response.editado === false) {
      mostrarMensagem(response.mensagem, "msg-edicao", "warning");
      return;
    }

    mostrarMensagem("Curso editado com sucesso!", "msg-edicao");
    form.reset();
  } catch (erro) {
    if (erro.status !== 500) {
      mostrarMensagem(erro.mensagem, "msg", "warning");
      return;
    }
    mostrarMensagem("Erro ao cadastrar curso.", "msg", "danger");
  } finally {
    btn.disabled = false;
  }
}

/**
 * Preenche os campos do formulário com os dados do curso selecionado.
 * @param {Array<Object>} cursos
 */
function addSelectChangeListener(cursos) {
  const select = document.getElementById("select-cursos-edicao");
  select.addEventListener("change", function () {
    if (!this.value) return;

    const cursoSelecionado = cursos.find((curso) => curso.id == this.value);

    if (cursoSelecionado) {
      document.getElementById("nome").value = cursoSelecionado.nome;
      document.getElementById("descricao").value = cursoSelecionado.descricao;
      document.getElementById("categoria").value = cursoSelecionado.categoria;
      document.getElementById("plataforma").value = cursoSelecionado.plataforma;
      document.getElementById("custo").value = cursoSelecionado.gratuito ? "Gratuito" : "Pago";
      document.getElementById("link").value = cursoSelecionado.url;
    }
  });
}
