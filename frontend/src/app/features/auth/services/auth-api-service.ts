import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { LoginRequest } from '../models/login-request';
import { AuthResponse } from '../models/auth-response';
import { CadastroRequest } from '../models/cadastro-request';
import { UsuarioAuth } from '../models/usuario-auth';

@Injectable({
  providedIn: 'root',
})
export class AuthApiService {

  private readonly apiBaseUrl: string = "/api/auth";

  private readonly httpClient: HttpClient = inject(HttpClient);

  autenticar(dados: LoginRequest): Observable<AuthResponse> {
    return this.httpClient.post<AuthResponse>(
      `${this.apiBaseUrl}/login`,
      dados
    );
  }

  cadastrar(dados: CadastroRequest): Observable<AuthResponse> {
    return this.httpClient.post<AuthResponse>(
      `${this.apiBaseUrl}/cadastro`,
      dados
    );
  }

  buscarDados(): Observable<UsuarioAuth> {
    return this.httpClient.get<UsuarioAuth>(
      `${this.apiBaseUrl}/me`
    );
  }
}
