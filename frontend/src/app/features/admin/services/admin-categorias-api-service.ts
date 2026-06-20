import { inject, Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { CategoriaRequest } from '../models/categoria-request';
import { Observable } from 'rxjs';
import { Categoria } from '../../categorias/models/categoria';
import { CategoriaApiService } from '../../categorias/services/categoria-api-service';

@Injectable({
  providedIn: 'root',
})
export class AdminCategoriasApiService {

  private readonly apiBaseUrl = "/api/categorias";

  private readonly httpClient: HttpClient = inject(HttpClient);

  private readonly categoriaApiService: CategoriaApiService = inject(CategoriaApiService);

  buscarCategorias(): Observable<Categoria[]> {
    return this.categoriaApiService.buscarCategorias();
  }

  buscarCategoriaPorId(categoriaId: number): Observable<Categoria> {
    return this.categoriaApiService.buscarCategoriaPorId(categoriaId);
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
