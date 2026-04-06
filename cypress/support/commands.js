// Comando de login a ser utilizado em diferentes testes
Cypress.Commands.add('login', () => {
  // https://docs.cypress.io/api/commands/env#Multiple-Variables
  cy.env(['email', 'senha']).then(({ email, senha }) => {
    cy.request({
      method: 'POST',
      url: '/login.php',
      form: true,
      body: {
        email: email,
        senha: senha
      }
    })
  })
})

// Comando para preencher um formulário com os dados de um curso
Cypress.Commands.add('preencherFormCurso', (
  nome,
  descricao,
  categoria,
  plataforma,
  custo,
  url
) => {
  if (nome !== "") cy.get('[name=nome]').type(nome)
  if (descricao !== "") cy.get('[name=descricao]').type(descricao)
  if (descricao !== "") cy.get('[name=categoria]').type(categoria)
  if (descricao !== "") cy.get('[name=plataforma]').type(plataforma)

  if (custo !== "") {
    cy.get('[name=custo]').select(custo)
    cy.get('select[name="custo"]')
      .find('option:selected')
      .should('contain', custo)
  }

  if (url !== "") cy.get('[name=link]').type(url)
})
