describe('Tela Sobre Nós', () => {
  beforeEach(() => {
    cy.visit('/sobre.php')
  })

  it('carrega estrutura principal', () => {
    cy.get('nav').should('exist')

    cy.get('footer').should('exist')

    cy.get('#sobre-section').should('exist')

    cy.get('#contato-section').should('exist')
  })
})
