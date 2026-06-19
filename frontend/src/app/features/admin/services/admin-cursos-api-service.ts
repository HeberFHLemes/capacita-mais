import { inject, Injectable } from '@angular/core';
import { Curso } from '../../cursos/models/curso';
import { Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { CursoRequest } from '../models/curso-request';

@Injectable({
  providedIn: 'root',
})
export class AdminCursosApiService {

  private readonly apiBaseUrl: string = "/api/cursos";

  private readonly httpClient: HttpClient = inject(HttpClient);

  buscarCursos(): Observable<Curso[]> {
    return this.httpClient.get<Curso[]>(`${this.apiBaseUrl}`);
  }

  buscarCursoPorId(cursoId: number): Observable<Curso> {
    return this.httpClient.get<Curso>(`${this.apiBaseUrl}/${cursoId}`);
  }

  cadastrarCurso(curso: CursoRequest): Observable<Curso> {
    return this.httpClient.post<Curso>(this.apiBaseUrl, curso);
  }

  editarCurso(curso: CursoRequest, cursoId: number): Observable<Curso> {
    return this.httpClient.put<Curso>(`${this.apiBaseUrl}/${cursoId}`, curso);
  }

  removerCurso(cursoId: number): Observable<void> {
    return this.httpClient.delete<void>(`${this.apiBaseUrl}/${cursoId}`);
  }
}
