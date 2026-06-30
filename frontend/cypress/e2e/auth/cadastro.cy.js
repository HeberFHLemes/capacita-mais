describe('Tela de cadastro', () => {
  beforeEach(() => {
    cy.visit('/cadastro')
  })

  const preencherCadastro = (email, nome, senha, senhaConfirma) => {
    cy.get('#email').type(email)
    cy.get('#nome').type(nome)
    cy.get('#senha').type(senha)
    cy.get('#confirmar-senha').type(senhaConfirma)
  }

  it('CT19 - Cadastra novo usuário comum', () => {

    const nome =  `Comum${Date.now()}`
    const email = `${nome}@email.com`
    const senha = `${nome}-senha`

    preencherCadastro(email, nome, senha, senha)

    cy.get('form').submit()

    cy.location('pathname').should('eq', '/')
  })
})
