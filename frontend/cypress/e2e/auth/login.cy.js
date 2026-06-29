describe('Tela de login', () => {
  beforeEach(() => {
    cy.visit('/login')
  })

  const preencherLogin = (email, senha) => {
    cy.get('#email').type(email)
    cy.get('#senha').type(senha)
  }

  it('CT1 - Autentica usuário com credenciais válidas', () => {
    cy.env(['email', 'senha']).then(({ email, senha }) => {
      preencherLogin(email, senha)

      cy.get('form').submit()

      cy.location('pathname').should('eq', '/admin/cursos')
    })
  })

  it('CT2 - Não autentica com senha incorreta', () => {
    cy.env(['email']).then(({ email }) => {
      preencherLogin(email, 'senhaincorreta')

      cy.get('form').submit()

      cy.location('pathname').should('eq', '/login')
    })
  })

  it('CT3 - Não autentica com e-mail incorreto', () => {
    preencherLogin('email@falso.com', 'souadmin')

    cy.get('form').submit()

    cy.location('pathname').should('eq', '/login')
  })

  it('CT4 - Valida campos obrigatórios na autenticação', () => {
    cy.get('#email').invoke('removeAttr', 'required')
    cy.get('#senha').invoke('removeAttr', 'required')

    cy.get('form').submit()

    cy.location('pathname').should('eq', '/login')
  })

  it('CT5 - Exige autenticação na área administrativa', () => {
    cy.visit('/admin')

    cy.location().should((loc) => {
      expect(loc.pathname).to.eq('/login')
      expect(loc.search).to.contain('returnUrl=')
    })
  })
})
