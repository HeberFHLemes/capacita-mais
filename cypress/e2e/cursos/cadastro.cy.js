describe('Cadastro de cursos', () => {
  beforeEach(() => {
    cy.login()
    cy.visit('/cadastro.php')
  })

  it('cadastra novo curso', () => {
    cy.fixture('cursos').then((curso) => {
      // para garantir a unicidade do curso,
      // concatena o nome com a data atual do teste
      const nome = `${curso.novo.baseNome} ${Date.now()}`

      const custo = curso.novo.gratuito ? 'Gratuito' : 'Pago'

      cy.get('[name=nome]').type(nome)
      cy.get('[name=descricao]').type(curso.novo.descricao)
      cy.get('[name=categoria]').type(curso.novo.categoria)
      cy.get('[name=plataforma]').type(curso.novo.plataforma)

      cy.get('[name=custo]').select(custo)
      cy.get('select[name="custo"]')
        .find('option:selected')
        .should('contain', custo)

      cy.get('[name=link]').type(curso.novo.url)

      // salva a requisição para obter depois a resposta dela
      cy.intercept('POST', '/api/cursos.php').as('postCurso')

      // submit
      cy.contains('Cadastrar Curso').click()

      // requisição deve retornar 201
      cy.wait('@postCurso').its('response.statusCode').should('eq', 201)

      // Na resposta, em vez de conferir o texto em si na tela do form,
      // confere se há o componente de mensagem, está sem 'd-none',
      // está com alert-success e tem (qualquer) texto dentro.
      // https://docs.cypress.io/app/references/assertions#Chai-jQuery
      cy.get('#msg')
        .should('not.have.class', 'd-none')
        .and('have.class', 'alert-success')
        .and('not.be.empty')
    })
  })
})
