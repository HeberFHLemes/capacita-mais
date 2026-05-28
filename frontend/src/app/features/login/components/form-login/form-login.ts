import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-form-login',
  standalone: true,
  templateUrl: './form-login.html',
  styleUrl: './form-login.css',
})
export class FormLogin {

  formLogin: FormGroup;

  constructor(private fb: FormBuilder) {
    this.formLogin = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
      senha: ['', [Validators.required, Validators.minLength(3)]]
    });
  }

  onSubmit() {
    if (this.formLogin.valid) {
      // Enviar requisição pro backend e salvar token
    }
  }

}
