import { Component, inject } from '@angular/core';
import { FormControl, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { AuthService } from '../../services/auth-service';

@Component({
  selector: 'app-login-page',
  standalone: true,
  imports: [
    FormsModule,
    ReactiveFormsModule,
    RouterLink
  ],
  templateUrl: './login-page.html',
  styleUrl: './login-page.css',
})
export class LoginPage {
  loginForm = new FormGroup({
    email: new FormControl<string>('', {
      nonNullable: true,
      validators: [
        Validators.required,
        Validators.email
      ]
    }),
    senha: new FormControl<string>('', {
      nonNullable: true,
      validators: [
        Validators.required
      ]
    })
  });

  private readonly authService: AuthService = inject(AuthService);

  private readonly route: ActivatedRoute = inject(ActivatedRoute);
  private readonly router: Router = inject(Router);

  realizarLogin() {
    if (this.loginForm.invalid) {
      this.loginForm.markAllAsTouched();
      return;
    }

    const dados = this.loginForm.getRawValue();

    this.authService
      .login(dados)
      .subscribe({
        next: () => {
          const returnUrl =
            this.route.snapshot.queryParamMap.get('returnUrl');

          this.redirecionar(returnUrl);
        },
        error: (err) => {
          console.error(err);
        }
      });
  }

  private redirecionar(url: string|null): void {
    if (url?.startsWith('/')) {
      this.router.navigateByUrl(url);
      return;
    }

    if (this.authService.isAdmin()) {
      this.router.navigate(['/admin']);

    } else {
      this.router.navigate(['/']);
    }
  }
}
