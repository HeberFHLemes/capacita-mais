import { Injectable } from '@angular/core';
import { CursosApiService } from '../../cursos/services/cursos-api-service';
import { Curso } from '../../cursos/models/curso';

@Injectable({
  providedIn: 'root',
})
export class CrudCursosService extends CursosApiService {

  /*
   * TODO: tratar responses e exceções, comunicação com componentes.
   */

  // TODO
  async cadastrarCurso(curso: Curso) {
    return this.httpClient.post<any>(this.apiBaseUrl, curso);
  }

  // TODO
  async editarCurso(cursoId: number, curso: Curso) {
    return this.httpClient.put<any>(`${this.apiBaseUrl}/${cursoId}`, curso);
  }

  // TODO
  async removerCurso(cursoId: number) {
    return this.httpClient.delete<any>(`${this.apiBaseUrl}/${cursoId}`);
  }

}
