describe('Edição de cursos', () => {

  beforeEach(() => {
    cy.login()
    cy.visit('/admin/cursos')
  })

  const selecionarPrimeiroCurso = () => {
    cy.intercept('GET', '**/api/cursos/*').as('getCurso')

    cy.get('.card-curso')
      .first()
      .contains('button', 'Editar')
      .click()

    cy.wait('@getCurso')

    // conferir rota (regex por conta do id) e retornar o id
    return cy.location('pathname')
      .invoke('match', /^\/admin\/cursos\/(\d+)\/editar$/)
      .its('1')
  }

  it('CT15 - Seleção de um curso existente para edição', () => {
    selecionarPrimeiroCurso().then(() => {
      // campos de tipo input obrigatórios devem estar preenchidos
      cy.get('form')
        .find('input[required]')
        .should('have.length.greaterThan', 0)
        .each(($input) => {
          cy.wrap($input).should('not.have.value', '')
        })
    })
  })

  it('CT16 - Edição de um curso existente', () => {
    selecionarPrimeiroCurso().then((cursoId) => {

      cy.intercept('PUT', `/api/cursos/${cursoId}`).as('putCurso')

      // editar o nome
      const nome = `Editado ${Date.now()}`
      cy.get('[name=nome]').clear().type(nome)

      cy.get('form').submit()

      // status 200 OK
      cy.wait('@putCurso').its('response.statusCode').should('eq', 200)
    })
  })

  it('CT17 - Edição sem alterações nos dados', () => {
    selecionarPrimeiroCurso().then(() => {

      cy.get('form').submit()

      cy.get('app-alerta > div')
        .should('have.class', 'alert-warning')
        .and('be.visible')
    })
  })
})
