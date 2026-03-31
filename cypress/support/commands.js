// ***********************************************
// This example commands.js shows you how to
// create various custom commands and overwrite
// existing commands.
//
// For more comprehensive examples of custom
// commands please read more here:
// https://on.cypress.io/custom-commands
// ***********************************************
//
//
// -- This is a parent command --
// Cypress.Commands.add('login', (email, password) => { ... })
//
//
// -- This is a child command --
// Cypress.Commands.add('drag', { prevSubject: 'element'}, (subject, options) => { ... })
//
//
// -- This is a dual command --
// Cypress.Commands.add('dismiss', { prevSubject: 'optional'}, (subject, options) => { ... })
//
//
// -- This will overwrite an existing command --
// Cypress.Commands.overwrite('visit', (originalFn, url, options) => { ... })

// Comando de login a ser utilizado em diferentes testes
Cypress.Commands.add('login', () => {
  // https://docs.cypress.io/api/commands/env#Multiple-Variables
  cy.env(['email', 'senha']).then(({ email, senha }) => {
    cy.request({
      method: 'POST',
      url: '/login.php',
      form: true,
      body: {
        email: email,
        senha: senha
      }
    })
  })
})
