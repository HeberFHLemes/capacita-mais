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

  const enviarCadastro = () => cy.get('[type=submit]').click()

  const baseNome = 'Comum'

  it('CT20 - Cadastra novo usuário comum', () => {

    const email = `${baseNome}@email.com`
    const nome = `${baseNome}-${Date.now()}`
    const senha = `${baseNome}-senha`

    preencherCadastro(email, nome, senha, senha)
    enviarCadastro()

    cy.location('pathname').should('eq', '/')
  })
})
