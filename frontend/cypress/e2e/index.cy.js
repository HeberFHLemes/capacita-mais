describe('Tela inicial', () => {
  beforeEach(() => {
    cy.visit('/')
  })

  it('carrega estrutura básica', () => {
    cy.get('nav').should('exist')

    cy.get('header.hero-section').should('exist')

    cy.get('footer').should('exist')
  })
})
