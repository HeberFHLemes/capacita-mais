import { Component, inject } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { RouterLink } from '@angular/router';
import { AuthApiService } from '../../../services/auth-api-service';
import { LoginRequest } from '../../../models/login-request';

@Component({
  selector: 'app-login-page',
  standalone: true,
  imports: [RouterLink, ReactiveFormsModule],
  templateUrl: './login-page.html',
  styleUrl: './login-page.css',
})
export class LoginPage {

  loginForm = new FormGroup({
    email: new FormControl('', [
      Validators.required,
      Validators.email
    ]),
    senha: new FormControl('', [
      Validators.required
    ])
  });

  private readonly authService: AuthApiService = inject(AuthApiService);

  realizarLogin() {
    if (this.loginForm.invalid) {
      this.loginForm.markAllAsTouched();
      return;
    }

    const dados = this.loginForm.getRawValue();

    this.authService.autenticar(dados as LoginRequest).subscribe(
      (resposta) => {
        // TODO: implementar manipulação da resposta (salvar o token)
      }
    )
  }
}
