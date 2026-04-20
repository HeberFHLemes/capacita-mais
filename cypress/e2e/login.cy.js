describe('Tela de login', () => {
  beforeEach(() => {
    cy.visit('/login')
  })

  const preencherLogin = (email, senha) => {
    cy.get('[name=email]').type(email)
    cy.get('[name=senha]').type(senha)
    cy.get('[type=submit]').click()
  }

  it('CT1 - Autentica usuário com credenciais válidas', () => {
    cy.env(['email', 'senha']).then(({ email, senha }) => {
      preencherLogin(email, senha)

      cy.location('pathname').should('eq', '/cadastro')
    })
  })

  it('CT2 - Não autentica com senha incorreta', () => {
    cy.env(['email']).then(({ email }) => {
      preencherLogin(email, 'senhaincorreta')

      cy.location('pathname').should('eq', '/login')

      cy.get('.alert-danger').should('be.visible').and('not.be.empty')
    })
  })

  it('CT3 - Não autentica com e-mail incorreto', () => {
    preencherLogin('email@falso.com', 'souadmin')

    cy.location('pathname').should('eq', '/login')

    cy.get('.alert-danger').should('be.visible').and('not.be.empty')
  })

  it('CT4 - Valida campos obrigatórios na autenticação', () => {
    cy.get('[name=email]').invoke('removeAttr', 'required')
    cy.get('[name=senha]').invoke('removeAttr', 'required')
    cy.get('[type=submit]').click()

    cy.location('pathname').should('eq', '/login')

    cy.get('.alert-danger').should('be.visible').and('not.be.empty')
  })

  it('CT5 - Exige autenticação nos formulários administrativos', () => {
    cy.visit('/cadastro')

    cy.location('pathname').should('eq', '/login')
  })
})
