describe('Remoção de cursos', () => {
  beforeEach(() => {
    cy.login()
    cy.visit('/admin/cursos')
  })

  it('CT18 - Remoção de um curso existente', () => {

    cy.get('.card-curso').first().within(() => {

      cy.get('.card-title')
        .invoke('text')
        .then((cursoNome) => {

          cy.intercept('DELETE', '**/api/cursos/*').as('deleteCurso')

          cy.contains('button', 'Remover').click()

          cy.wait('@deleteCurso')
            .its('response.statusCode')
            .should('eq', 204)

          cy.reload()

          cy.contains('.card-title', cursoNome.trim())
            .should('not.exist')
        })
    })
  })
})
