describe('Cadastro de cursos', () => {
  beforeEach(() => {
    cy.login()
    cy.visit('/admin/cursos/novo-curso')
  })

  it('CT12 - Cadastro de novos cursos', () => {
    cy.fixture('cursos').then((curso) => {
      // para garantir a unicidade do curso,
      // concatena o nome com a data atual do teste
      const nome = `${curso.novo.baseNome} ${Date.now()}`

      cy.preencherFormCurso(
        nome,
        curso.novo.descricao,
        curso.novo.categoria_id,
        curso.novo.nivel,
        curso.novo.preco,
        curso.novo.preco_original,
        curso.novo.em_destaque
      )

      // salva a requisição para obter depois a resposta dela
      cy.intercept('POST', '/api/cursos').as('postCurso')

      // submit
      cy.get('form').submit()

      // requisição deve retornar 201
      cy.wait('@postCurso').its('response.statusCode').should('eq', 201)

      cy.get('app-alerta > div')
        .should('have.class', 'alert-success')
        .and('not.be.empty')
        .and('be.visible')
    })
  })

  it('CT13 - Valida campos obrigatórios no cadastro', () => {
    cy.get('[name=nome]').invoke('removeAttr', 'required')
    cy.get('[name=categoria]').invoke('removeAttr', 'required')
    cy.get('[name=preco]').invoke('removeAttr', 'required')
    cy.get('[name=preco_original]').invoke('removeAttr', 'required')
    // em_destaque e nivel não validados (valores iniciais)

    cy.intercept('POST', '/api/cursos').as('postCurso')

    cy.get('form').submit()

    cy.get('@postCurso.all').should('have.length', 0)
  })

  it('CT14 - Não cadastra curso duplicado', () => {
    cy.fixture('cursos').then((curso) => {
      const nome = `${curso.novo.baseNome} ${Date.now()}`

      // cadastra curso válido
      cy.preencherFormCurso(
        nome,
        curso.novo.descricao,
        curso.novo.categoria_id,
        curso.novo.nivel,
        curso.novo.preco,
        curso.novo.preco_original,
        curso.novo.em_destaque
      )

      cy.intercept('POST', '/api/cursos').as('postCurso1')

      cy.get('form').submit()

      cy.wait('@postCurso1').its('response.statusCode').should('eq', 201)

      cy.get('app-alerta > div')
        .should('have.class', 'alert-success')
        .and('not.be.empty')
        .and('be.visible')

      // tenta cadastrar um curso com o mesmo nome, categoria e nivel
      cy.preencherFormCurso(nome, 'descrição', curso.novo.categoria_id, curso.novo.nivel, 10, 10, true)

      cy.intercept('POST', '/api/cursos').as('postCurso2')

      cy.get('form').submit()

      // deve falhar e informar o usuário
      cy.wait('@postCurso2').its('response.statusCode').should('eq', 409)

      cy.get('app-alerta > div')
        .should('have.class', 'alert-warning')
        .and('not.be.empty')
        .and('be.visible')
    })
  })
})
