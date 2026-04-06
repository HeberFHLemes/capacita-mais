describe('Remoção de cursos', () => {

    const SELECT = "select-cursos-remocao"

    beforeEach(() => {
        cy.login()
        cy.visit('/remocao.php')
    })

    // Mesmo lógica do componente select da página de edição
    it('carrega o select de cursos', () => {

        // elemento deve estar visível...
        cy.get(`[name=${SELECT}]`)
            .should('be.visible');
        
        // ...e ter mais de uma opção
        // sendo que a primeira é a "placeholder" (mesmo com hidden e disabled)
        cy.get(`[name=${SELECT}]`)
            .find('option')
            .should('have.length.greaterThan', 1);

    })

    it('remove um curso existente', () => {

        // "salva" o id e o nome do curso que foi selecionado no select
        cy.selecionarEmSelect(SELECT)
            .then(({ value: cursoId, textContent: cursoNome }) => {

            cy.intercept('DELETE', `/api/cursos.php?id=${cursoId}`)
                .as('deleteCurso')

            cy.get('[type=submit]').click()

            cy.wait('@deleteCurso')
                .its('response.statusCode')
                .should('eq', 204)

            // mensagem de sucesso
            cy.get('#msg-remocao')
                .should('not.have.class', 'd-none')
                .and('have.class', 'alert-success')
                .and('not.be.empty')

            // recarrega a página
            cy.reload()

            // curso deve desaparecer do select
            cy.get(`[name="${SELECT}"]`)
                .find('option')
                .should('not.contain', cursoNome)

        })

    })

})