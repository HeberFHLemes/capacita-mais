describe("Tela inicial", () => {

  beforeEach(() => {
    cy.visit("/")
  })

  it("carrega estrutura principal", () => {

    cy.get("nav")
      .should("exist")
    
    cy.get("header.hero-section")
      .should("exist")
    
    cy.get("footer")
      .should("exist")

  })
  
  it("redireciona para cursos", () => {

    cy.get('[data-cy="btn-explorar-cursos"]')
      .should("be.visible")
      .click()

    cy.location("pathname")
      .should("eq", "/cursos.php")

  })

})