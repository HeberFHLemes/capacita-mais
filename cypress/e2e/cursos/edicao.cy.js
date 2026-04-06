describe('Edição de cursos', () => {
  const SELECT = 'select-cursos-edicao'

  beforeEach(() => {
    cy.login()
    cy.visit('/edicao.php')
  })

  it('carrega o select de cursos', () => {
    // elemento deve estar visível...
    cy.get(`[name=${SELECT}]`).should('be.visible')

    // ...e ter mais de uma opção
    // sendo que a primeira é a "placeholder" (mesmo com hidden e disabled)
    cy.get(`[name=${SELECT}]`).find('option').should('have.length.greaterThan', 1)
  })

  it('popula campos ao selecionar curso', () => {
    cy.selecionarEmSelect(SELECT)

    // campos de tipo input obrigatórios devem estar preenchidos
    cy.get('input[required]')
      .should('have.length.greaterThan', 0)
      .each(($input) => {
        cy.wrap($input).should('not.have.value', '')
      })
  })

  it('edita um curso existente', () => {
    cy.selecionarEmSelect(SELECT).then(({ value: cursoId }) => {
      cy.intercept('PUT', `/api/cursos.php?id=${cursoId}`).as('putCurso')

      // editar o nome
      const nome = `Editado ${Date.now()}`
      cy.get('[name=nome]').clear().type(nome)

      cy.get('[type=submit]').click()

      // status 200
      cy.wait('@putCurso').its('response.statusCode').should('eq', 200)
    })
  })

  it('informa que não houve alterações', () => {
    cy.selecionarEmSelect(SELECT).then(({ value: cursoId }) => {
      cy.intercept('PUT', `/api/cursos.php?id=${cursoId}`).as('putCurso')

      cy.get('[type=submit]').click()

      // status 200
      cy.wait('@putCurso').its('response.statusCode').should('eq', 200)

      cy.get('#msg-edicao')
        .should('not.have.class', 'd-none')
        .and('have.class', 'alert-warning')
        .and('not.be.empty')
    })
  })
})
