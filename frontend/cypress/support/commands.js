// Comando de login a ser utilizado em diferentes testes
Cypress.Commands.add('login', () => {
  cy.env(['email', 'senha']).then(({ email, senha }) => {
    cy.request({
      method: 'POST',
      url: '/login',
      body: {
        email: email,
        senha: senha,
      },
    })
  })
})

// Comando para preencher um formulário com os dados de um curso
Cypress.Commands.add('preencherFormCurso',
  (nome, descricao, categoria_id, preco, preco_original, em_destaque) => {
    if (nome !== "") cy.get('[name=nome]').type(nome)
    if (descricao !== "") cy.get('[name=descricao]').type(descricao)

    // TODO: refatorar preenchimento dos formulários de cursos.

    cy.get('[name=em_destaque]').type(em_destaque ?? false);
  })

// Comando para selecionar a última opção de um select
// e retornar seu valor e texto
Cypress.Commands.add('selecionarEmSelect', (elemento) => {
  return cy
    .get(`[name=${elemento}]`)
    .should('be.visible')
    .find('option:enabled:last') // seleciona a última opção
    .then(($option) => {
      const value = $option.val()
      const textContent = $option.text()

      // retorna tanto o valor como o texto apresentado
      return cy
        .get(`[name="${elemento}"]`)
        .select(value)
        .should('have.value', value)
        .then(() => ({ value, textContent }))
    })
})
