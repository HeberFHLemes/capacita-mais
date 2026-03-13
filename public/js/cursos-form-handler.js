const API_PATH = "api/cursos.php";

/**
 * Classe para centralizar a lógica dos forms de curso.
 *
 * Preparando para evoluir leitura de arquivo JSON
 * para consumo de API ou integração com PHP.
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

    const curso = {
      titulo: formData.get("titulo"),
      descricao: formData.get("descricao"),
      categoria: formData.get("categoria"),
      plataforma: formData.get("plataforma"),
      gratuito: formData.get("custo") === "Gratuito",
      url: formData.get("link"),
    };

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
      this.mostrarMensagem("Erro ao cadastrar curso.", mensagemElementId, true);
      console.error(erro);
    } finally {
      btn.disabled = false;
    }
  }

  editar(
    event,
    selectElementId = "select-cursos-edicao",
    mensagemElementId = "msg-edicao",
    mensagemErro = "Por favor, selecione um curso válido.",
    mensagemSucesso = "Curso editado com sucesso!"
  ) {
    event.preventDefault();

    const select = document.getElementById(selectElementId);

    if (!select.value) {
      this.mostrarMensagem(mensagemErro, mensagemElementId, "danger");
      return;
    }

    this.mostrarMensagem(mensagemSucesso, mensagemElementId);

    event.target.reset();
  }

  remover(
    event,
    selectElementId = "select-cursos-remocao",
    mensagemElementId = "msg-remocao",
    mensagemErro = "Por favor, selecione um curso válido.",
    mensagemSucesso = "Curso removido com sucesso!"
  ) {
    event.preventDefault();

    const select = document.getElementById(selectElementId);

    if (!select.value) {
      this.mostrarMensagem(mensagemErro, mensagemElementId, "danger");
      return;
    }

    select.remove(select.selectedIndex);

    this.mostrarMensagem(mensagemSucesso, mensagemElementId);

    event.target.reset();
  }

  mostrarMensagem(mensagem, elementId, type = "success") {
    const msg = document.getElementById(elementId);
    msg.textContent = mensagem;
    msg.classList.remove("d-none", "alert-success", "alert-danger");
    msg.classList.add(`alert-${type}`);
    msg.scrollIntoView({ behavior: "smooth", block: "center" });
  }

  async enviarRequest(method, body) {
    try {
      const response = await fetch(API_PATH, {
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
}
