import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Curso } from '../models/curso';

@Injectable({
  providedIn: 'root',
})
export class CursosApiService {
  protected readonly apiBaseUrl = "/api/cursos";

  constructor(protected httpClient: HttpClient) {}

  buscarCursos(): Observable<Curso[]> {
    return this.httpClient.get<Curso[]>(this.apiBaseUrl);
  }

  buscarCursosEmDestaque(): Observable<Curso[]> {
    return this.httpClient.get<Curso[]>(`${this.apiBaseUrl}/destaques`);
  }
}
