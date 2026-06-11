import { computed, inject, Injectable, signal } from '@angular/core';
import { UsuarioAuth } from '../models/usuario-auth';
import { Perfil } from '../models/perfil';
import { AuthResponse } from '../models/auth-response';
import { LoginRequest } from '../models/login-request';
import { map, Observable, tap } from 'rxjs';
import { AuthApiService } from './auth-api-service';
import { CadastroRequest } from '../models/cadastro-request';

@Injectable({
  providedIn: 'root',
})
export class AuthService {

  private readonly apiService: AuthApiService = inject(AuthApiService);

  private usuarioSignal =
    signal<UsuarioAuth | null>(null);

  readonly usuario =
    this.usuarioSignal.asReadonly();

  readonly isUsuarioAutenticado =
    computed(() => this.usuario() !== null);

  readonly isAdmin =
    computed(() =>
      this.usuario()?.perfil === Perfil.ADMIN
    );

  private readonly tokenKey: string = 'authToken';

  login(request: LoginRequest): Observable<void> {
    return this.apiService.autenticar(request)
      .pipe(
        tap(response => this.persistirSessao(response)),
        map(() => {}) // para retonar o Observable com void
      );
  }

  cadastrar(request: CadastroRequest): Observable<void> {
    return this.apiService.cadastrar(request)
      .pipe(
        tap(response => this.persistirSessao(response)),
        map(() => {})
      );
  }

  // TODO: explorar outras alternativas do localStorage
  private persistirSessao(response: AuthResponse): void {
    localStorage.setItem(
      this.tokenKey,
      response.token
    );

    this.usuarioSignal.set(
      response.usuario
    );
  }

  logout(): void {
    localStorage.removeItem(this.tokenKey);
    this.usuarioSignal.set(null);
  }

  getToken(): string|null {
    return localStorage.getItem(this.tokenKey);
  }
}
