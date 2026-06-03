import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Categoria } from '../models/categoria';

@Injectable({
  providedIn: 'root',
})
export class CategoriaApiService {

  private readonly apiBaseUrl = "/api/categorias";

  private readonly httpClient: HttpClient = inject(HttpClient);

  buscarCategorias(): Observable<Categoria[]> {
    return this.httpClient.get<Categoria[]>(this.apiBaseUrl);
  }
}
