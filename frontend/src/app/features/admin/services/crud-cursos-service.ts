import { inject, Injectable } from '@angular/core';
import { Curso } from '../../cursos/models/curso';
import { Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root',
})
export class AdminCursosApiService {

  private readonly apiBaseUrl: string = "/api/cursos";

  private readonly httpClient: HttpClient = inject(HttpClient);

  /*
   * TODO: Revisar tipos.
   */

  cadastrarCurso(curso: Curso): Observable<any> {
    return this.httpClient.post<any>(this.apiBaseUrl, curso);
  }

  editarCurso(curso: Curso): Observable<any> {
    return this.httpClient.put<any>(`${this.apiBaseUrl}/${curso.id}`, curso);
  }

  removerCurso(cursoId: number): Observable<any> {
    return this.httpClient.delete<any>(`${this.apiBaseUrl}/${cursoId}`);
  }
}
