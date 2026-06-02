import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Curso } from '../models/curso';

@Injectable({
  providedIn: 'root',
})
export class CursosApiService {

  private readonly apiBaseUrl = "/api/cursos";

  private readonly httpClient: HttpClient = inject(HttpClient);

  buscarCursos(): Observable<Curso[]> {
    return this.httpClient.get<Curso[]>(this.apiBaseUrl);
  }

  buscarCursosEmDestaque(): Observable<Curso[]> {
    return this.httpClient.get<Curso[]>(`${this.apiBaseUrl}/destaques`);
  }
}
