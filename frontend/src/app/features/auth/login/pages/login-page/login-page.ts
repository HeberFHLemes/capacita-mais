import { Component } from '@angular/core';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-login-page',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './login-page.html',
  styleUrl: './login-page.css',
})
export class LoginPage {

  realizarLogin() {
    // TODO: implementar submit e validação do form,
    // além de envio da req pra api e manipulação da resposta (salvar o token)
  }
}
