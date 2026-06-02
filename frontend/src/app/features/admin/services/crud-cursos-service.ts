import { Injectable } from '@angular/core';
import { CursosApiService } from '../../cursos/services/cursos-api-service';
import { Curso } from '../../cursos/models/curso';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class CrudCursosService extends CursosApiService {

  /*
   * TODO: Revisar tipos.
   */

  cadastrarCurso(curso: Curso): Observable<any> {
    return this.httpClient.post<any>(this.apiBaseUrl, curso);
  }

  editarCurso(cursoId: number, curso: Curso): Observable<any> {
    return this.httpClient.put<any>(`${this.apiBaseUrl}/${cursoId}`, curso);
  }

  removerCurso(cursoId: number): Observable<any> {
    return this.httpClient.delete<any>(`${this.apiBaseUrl}/${cursoId}`);
  }
}
