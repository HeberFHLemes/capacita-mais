import { computed, inject, Injectable, signal } from '@angular/core';
import { UsuarioAuth } from '../models/usuario-auth';
import { Perfil } from '../models/perfil';
import { AuthResponse } from '../models/auth-response';
import { LoginRequest } from '../models/login-request';
import { map, Observable, tap } from 'rxjs';
import { AuthApiService } from './auth-api-service';
import { CadastroRequest } from '../models/cadastro-request';
import { AUTH_TOKEN_KEY } from '../constants/auth-constants';

@Injectable({
  providedIn: 'root',
})
export class AuthService {

  private readonly apiService: AuthApiService = inject(AuthApiService);

  constructor() {
    this.iniciarSessao();
  }

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

  iniciarSessao(): void {
    const token = this.getToken();

    if (!token) {
      return;
    }

    try { // primeiro se busca pelos dados do usuário pelo token
      const usuarioAuth = this.extrairPayload(token);
      this.usuarioSignal.set(usuarioAuth);

    } catch {
      this.logout();
    }

    // ...e depois, se busca na API os dados "atualizados" dele, de forma assíncrona.
    this.atualizarDadosDaSessao();
  }

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

  logout(): void {
    localStorage.removeItem(AUTH_TOKEN_KEY);
    this.usuarioSignal.set(null);
  }

  getToken(): string|null {
    return localStorage.getItem(AUTH_TOKEN_KEY);
  }

  // Consumo do endpoint /api/auth/me de forma assíncrona para popular o signal atualizado
  private atualizarDadosDaSessao(): void {
    this.apiService.buscarDados().subscribe({
      next: resposta => {
        this.usuarioSignal.set(resposta);
      },
      error: (err) => {
        // chamando o logout só quando o status é exatamente 401
        if (err.status === 401) {
          this.logout();
        }
      }
    });
  }

  private extrairPayload(token: string): UsuarioAuth {
    // extrair dados (UsuarioAuth) direto do payload do JWT.
    const payloadBase64 = token.split('.')[1];

    const payload = JSON.parse(
      atob(payloadBase64)
    );

    return {
      id: payload.sub,
      nome: payload.name,
      perfil: payload.role
    } as UsuarioAuth;
  }

  // TODO: explorar outras alternativas do localStorage
  private persistirSessao(response: AuthResponse): void {
    localStorage.setItem(AUTH_TOKEN_KEY, response.token);

    this.usuarioSignal.set(response.usuario);
  }
}
