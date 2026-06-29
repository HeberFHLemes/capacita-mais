// Comando de login a ser utilizado em diferentes testes
Cypress.Commands.add('login', () => {
  cy.env(['email', 'senha']).then(({ email, senha }) => {
    cy.request('POST', '/api/auth/login', {
      email: email,
      senha: senha,
    }).then(({status, body}) => {
      expect(status).to.eq(200)
      cy.window().then((win) => {
        win.localStorage.setItem('auth_token', body.token)
      })
    })
  })
})

// Comando para preencher um formulário com os dados de um curso
Cypress.Commands.add('preencherFormCurso', (
  nome, descricao, categoria_id, nivel, preco, preco_original, em_destaque
) => {
  if (nome !== "") cy.get('[name=nome]').type(nome)
  if (descricao !== "") cy.get('[name=descricao]').type(descricao)
  if (categoria_id !== null) cy.get('[name=categoria]').select(categoria_id)
  if (nivel !== null) cy.get(`input[value="${nivel}"]`).check()
  if (preco !== null) cy.get('[name=preco]').type(preco)
  if (preco_original !== null) cy.get('[name=preco_original]').type(preco)
  if (em_destaque !== null) {
    em_destaque ?
      cy.get('#em_destaque').check() :
      cy.get('#em_destaque').uncheck()
  }
})

// Comando para selecionar a última opção de um select e retornar seu valor e texto
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
