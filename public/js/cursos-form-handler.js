/**
 * Classe para centralizar a lógica dos forms de curso.
 * 
 * Preparando para evoluir leitura de arquivo JSON 
 * para consumo de API ou integração com PHP.
 */
export default class CursosFormHandler {

  constructor() {}  

  cadastrar(
    event,
    mensagemElementId = "msg",
    mensagemSucesso = "Curso cadastrado com sucesso!"
  ) {
    event.preventDefault();

    this.mostrarMensagem(mensagemSucesso, mensagemElementId);

    event.target.reset();
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
}
