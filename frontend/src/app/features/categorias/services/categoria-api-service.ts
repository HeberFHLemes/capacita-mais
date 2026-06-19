import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Categoria } from '../models/categoria';
import { CategoriaRequest } from '../../admin/models/categoria-request';

@Injectable({
  providedIn: 'root',
})
export class CategoriaApiService {

  private readonly apiBaseUrl = "/api/categorias";

  private readonly httpClient: HttpClient = inject(HttpClient);

  buscarCategorias(): Observable<Categoria[]> {
    return this.httpClient.get<Categoria[]>(this.apiBaseUrl);
  }

  buscarCategoriaPorId(categoriaId: number): Observable<Categoria> {
    return this.httpClient.get<Categoria>(`${this.apiBaseUrl}/${categoriaId}`);
  }

  cadastrarCategoria(categoria: CategoriaRequest): Observable<Categoria> {
    return this.httpClient.post<Categoria>(
      this.apiBaseUrl,
      { nome: categoria.nome }
    );
  }

  editarCategoria(categoria: CategoriaRequest, categoriaId: number): Observable<Categoria> {
    return this.httpClient.put<Categoria>(
      `${this.apiBaseUrl}/${categoriaId}`,
      { nome: categoria.nome }
    );
  }

  removerCategoria(categoriaId: number): Observable<void> {
    return this.httpClient.delete<void>(`${this.apiBaseUrl}/${categoriaId}`);
  }
}
