const API_PATH = "api/cursos.php";

/**
 * Classe para centralizar a lógica dos forms de curso.
 * 
 * Cadastro - POST /api/cursos.php
 * Edição   - PUT /api/cursos.php?id=[ID]
 * Remoção  - DELETE /api/curso.php?id=[ID]
 */
export default class CursosFormHandler {
  constructor() {}

  async cadastrar(
    event,
    mensagemElementId = "msg",
    mensagemSucesso = "Curso cadastrado com sucesso!"
  ) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    const curso = this.montarCursoDoForm(formData);

    const btn = form.querySelector("button[type='submit']");
    btn.disabled = true;

    try {
      const response = await this.enviarRequest("POST", curso);

      if (!response || !response.ok) {
        throw new Error("Erro HTTP: " + response.status);
      }

      this.mostrarMensagem(mensagemSucesso, mensagemElementId);
      form.reset();
    } catch (erro) {
      this.mostrarMensagem("Erro ao cadastrar curso.", mensagemElementId, "danger");
      console.error(erro);
    } finally {
      btn.disabled = false;
    }
  }

  async editar(
    event,
    selectElementId = "select-cursos-edicao",
    mensagemElementId = "msg-edicao",
    mensagemErro = "Por favor, selecione um curso válido.",
    mensagemSucesso = "Curso editado com sucesso!"
  ) {
    event.preventDefault();

    const select = document.getElementById(selectElementId);

    const cursoId = select.value;

    if (!cursoId) {
      this.mostrarMensagem(mensagemErro, mensagemElementId, "danger");
      return;
    }

    const form = event.target;
    const formData = new FormData(form);

    const curso = this.montarCursoDoForm(formData);

    const btn = form.querySelector("button[type='submit']");
    btn.disabled = true;

    try {
      const apiUrl = `${API_PATH}?id=${cursoId}`;
      const response = await this.enviarRequest("PUT", curso, apiUrl);

      if (!response) {
        throw new Error("Sem resposta do servidor.");
      }

      const data = await response.json();

      if (!response.ok) {
        throw { response, data };
      }

      if (data.editado === false) {
        this.mostrarMensagem(data.mensagem, mensagemElementId, "warning");
        return;
      }

      // Mantendo reload da página manual por enquanto.
      // O usuário terá que recarregar a página para refletir as alterações,
      // se fizesse via js, teria que passar a mensagem de erro/sucesso 
      // para a página atualizada...

      this.mostrarMensagem(mensagemSucesso, mensagemElementId);
      form.reset();
    } catch (erro) {
      // Mostra mensagem de erro retornada pelo back-end ou padrão
      const mensagem = erro.data?.erro ?? "Erro ao editar curso.";
      this.mostrarMensagem(mensagem, mensagemElementId, "danger");
      console.error(erro);
    } finally {
      btn.disabled = false;
    }
  }

  async remover(
    event,
    selectElementId = "select-cursos-remocao",
    mensagemElementId = "msg-remocao",
    mensagemErro = "Por favor, selecione um curso válido.",
    mensagemSucesso = "Curso removido com sucesso!"
  ) {
    event.preventDefault();

    const form = event.target;
    const select = document.getElementById(selectElementId);

    const cursoId = select.value;

    if (!cursoId) {
      this.mostrarMensagem(mensagemErro, mensagemElementId, "danger");
      return;
    }

    const btn = form.querySelector("button[type='submit']");
    btn.disabled = true;

    try {
      const apiUrl = `${API_PATH}?id=${cursoId}`;
      const response = await this.enviarRequest("DELETE", null, apiUrl);

      if (!response || !response.ok) {
        throw new Error("Erro HTTP: " + response.status);
      }

      select.remove(select.selectedIndex);

      this.mostrarMensagem(mensagemSucesso, mensagemElementId);
      form.reset();
    } catch (erro) {
      this.mostrarMensagem("Erro ao remover curso.", mensagemElementId, "danger");
      console.error(erro);
    } finally {
      btn.disabled = false;
    }
  }

  mostrarMensagem(mensagem, elementId, type = "success") {
    const msg = document.getElementById(elementId);
    msg.textContent = mensagem;
    msg.classList.remove("d-none", "alert-success", "alert-danger", "alert-warning");
    msg.classList.add(`alert-${type}`);
    msg.scrollIntoView({ behavior: "smooth", block: "center" });
  }

  async enviarRequest(method, body, apiPath = API_PATH) {
    try {
      const response = await fetch(apiPath, {
        method: method,
        body: JSON.stringify(body),
        headers: {
          "Content-Type": "application/json; charset=UTF-8",
        },
      });

      return response;
    } catch (error) {
      console.error("Erro na requisição: ", error);
      throw error;
    }
  }

  montarCursoDoForm(formData) {
    return {
      nome: formData.get("nome"),
      descricao: formData.get("descricao"),
      categoria: formData.get("categoria"),
      plataforma: formData.get("plataforma"),
      gratuito: formData.get("custo") === "Gratuito",
      url: formData.get("link"),
    };
  }
}
