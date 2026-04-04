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

  it('não cadastra curso sem nome', () => {
    cy.fixture('cursos').then((curso) => {
      
      const custo = curso.novo.gratuito ? 'Gratuito' : 'Pago'
      
      // remove o required (HTML) do campo nome
      cy.get('[name=nome]').invoke('removeAttr', 'required');
      
      cy.get('[name=descricao]').type(curso.novo.descricao)
      cy.get('[name=categoria]').type(curso.novo.categoria)
      cy.get('[name=plataforma]').type(curso.novo.plataforma)

      cy.get('[name=custo]').select(custo)
      cy.get('select[name="custo"]')
        .find('option:selected')
        .should('contain', custo)

      cy.get('[name=link]').type(curso.novo.url)

      cy.intercept('POST', '/api/cursos.php').as('postCurso')

      cy.contains('Cadastrar Curso').click()

      // requisição deve retornar 400 (bad request)
      cy.wait('@postCurso').its('response.statusCode').should('eq', 400)

      // Confere se há mensagem de erro na tela
      cy.get('#msg')
        .should('not.have.class', 'd-none')
        .and('have.class', 'alert-danger')
        .and('not.be.empty')
    })
  })

  it('não cadastra curso em branco', () => {
    cy.fixture('cursos').then((curso) => {

      // remove o required (HTML) de todos os campos obrigatórios
      cy.get('[name=nome]').invoke('removeAttr', 'required')
      cy.get('[name=categoria]').invoke('removeAttr', 'required')
      cy.get('[name=plataforma]').invoke('removeAttr', 'required')
      cy.get('[name=custo]').invoke('removeAttr', 'required')
      cy.get('[name=link]').invoke('removeAttr', 'required')

      cy.intercept('POST', '/api/cursos.php').as('postCurso')

      cy.contains('Cadastrar Curso').click()

      // requisição deve retornar 400 (bad request)
      cy.wait('@postCurso').its('response.statusCode').should('eq', 400)

      // Confere se há mensagem de erro na tela
      cy.get('#msg')
        .should('not.have.class', 'd-none')
        .and('have.class', 'alert-danger')
        .and('not.be.empty')
    })
  })

  it('não cadastra curso duplicado', () => {
    cy.fixture('cursos').then((curso) => {

      const nome = `${curso.novo.baseNome} ${Date.now()}`
      const custo = curso.novo.gratuito ? 'Gratuito' : 'Pago'

      // cadastra curso válido
      cy.preencherFormCurso(
        nome,
        curso.novo.descricao,
        curso.novo.categoria,
        curso.novo.plataforma,
        custo,
        curso.novo.url
      )

      cy.intercept('POST', '/api/cursos.php').as('postCurso1')
      
      cy.contains('Cadastrar Curso').click()
      
      cy.wait('@postCurso1').its('response.statusCode').should('eq', 201)

      cy.get('#msg')
        .should('not.have.class', 'd-none')
        .and('have.class', 'alert-success')
        .and('not.be.empty')

      // tenta cadastrar um curso com o mesmo nome, plataforma e custo
      cy.preencherFormCurso(
        nome,
        'Outra descrição',
        'Outra categoria',
        curso.novo.plataforma,
        custo,
        'https://google.com/search?q=outro-link'
      )

      cy.intercept('POST', '/api/cursos.php').as('postCurso2')

      cy.contains('Cadastrar Curso').click()

      // deve falhar e informar o usuário
      cy.wait('@postCurso2').its('response.statusCode').should('eq', 409)
      cy.get('#msg')
        .should('not.have.class', 'd-none')
        .and('have.class', 'alert-danger')
        .and('not.be.empty')

    })
  })
})
