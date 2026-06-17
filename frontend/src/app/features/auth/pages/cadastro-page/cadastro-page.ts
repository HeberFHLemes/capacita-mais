import { Component, inject } from '@angular/core';
import { Router, RouterLink } from "@angular/router";
import {
  AbstractControl,
  FormControl,
  FormGroup,
  ReactiveFormsModule,
  ValidationErrors,
  ValidatorFn,
  Validators
} from '@angular/forms';
import {AuthService} from '../../services/auth-service';

@Component({
  selector: 'app-cadastro-page',
  standalone: true,
  imports: [RouterLink, ReactiveFormsModule],
  templateUrl: './cadastro-page.html',
  styleUrl: './cadastro-page.css',
})
export class CadastroPage {

  private verificarSeSenhasCoincidem: ValidatorFn =
    (control: AbstractControl): ValidationErrors | null => {

      const senha = control.get('senha')?.value;
      const senhaConfirma = control.get('senhaConfirma')?.value;

      return senha === senhaConfirma
        ? null
        : { notSame: true };
    };

  cadastroForm = new FormGroup({
    email: new FormControl<string>('', {
      nonNullable: true,
      validators: [
        Validators.required,
        Validators.email
      ]
    }),
    nome: new FormControl<string>('', {
      nonNullable: true,
      validators: [
        Validators.required
      ]
    }),
    senha: new FormControl<string>('', {
      nonNullable: true,
      validators: [
        Validators.required
      ]
    }),
    senhaConfirma: new FormControl<string>('', {
      nonNullable: true,
      validators: [
        Validators.required
      ]
    })
  }, { validators: this.verificarSeSenhasCoincidem });

  private readonly authService: AuthService = inject(AuthService);

  private readonly router: Router = inject(Router);

  realizarCadastro() {
    if (this.cadastroForm.invalid) {
      this.cadastroForm.markAllAsTouched();
      return;
    }

    const dados = this.cadastroForm.getRawValue();

    this.authService
      .cadastrar(dados)
      .subscribe({
        next: () => {
          this.router.navigate(['/']);
        },
        error: (err) => {
          console.error(err);
        }
      });
  }
}
