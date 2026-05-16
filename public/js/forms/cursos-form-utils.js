export function mostrarMensagem(mensagem, elementId, type = "success") {
  const msg = document.getElementById(elementId);
  msg.textContent = mensagem;
  msg.classList.remove("d-none", "alert-success", "alert-danger", "alert-warning");
  msg.classList.add(`alert-${type}`);
  msg.scrollIntoView({ behavior: "smooth", block: "center" });
}

export function montarCursoDoForm(formData) {
  return {
    nome: formData.get("nome"),
    descricao: formData.get("descricao"),
    categoria: formData.get("categoria"),
    plataforma: formData.get("plataforma"),
    gratuito: formData.get("custo") === "Gratuito",
    url: formData.get("link"),
  };
}
