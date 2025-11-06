document.getElementById("form-cadastro-curso").addEventListener("submit", function (e) {
  e.preventDefault();

  const titulo = document.getElementById("titulo").value;
  const msg = document.getElementById("msg");
  msg.textContent = `Curso "${titulo}" cadastrado com sucesso!`;
  msg.classList.remove("d-none");

  this.reset(); // Limpa os campos
});
