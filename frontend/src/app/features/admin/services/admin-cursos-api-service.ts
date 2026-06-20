import { inject, Injectable } from '@angular/core';
import { Curso } from '../../cursos/models/curso';
import { Observable } from 'rxjs';
import { HttpClient } from '@angular/common/http';
import { CursoRequest } from '../models/curso-request';
import { CadastrarCursoResponse } from '../models/cadastrar-curso-response';
import { EditarCursoResponse } from '../models/editar-curso-response';
import { CursosApiService } from '../../cursos/services/cursos-api-service';

@Injectable({
  providedIn: 'root',
})
export class AdminCursosApiService {

  private readonly apiBaseUrl: string = "/api/cursos";

  private readonly httpClient: HttpClient = inject(HttpClient);

  // Operações públicas
  private readonly cursoApiService: CursosApiService = inject(CursosApiService);

  buscarCursos(): Observable<Curso[]> {
    return this.cursoApiService.buscarCursos();
  }

  buscarCursoPorId(cursoId: number): Observable<Curso> {
    return this.cursoApiService.buscarCursoPorId(cursoId);
  }

  cadastrarCurso(curso: CursoRequest): Observable<CadastrarCursoResponse> {
    return this.httpClient.post<CadastrarCursoResponse>(this.apiBaseUrl, curso);
  }

  editarCurso(curso: CursoRequest, cursoId: number): Observable<EditarCursoResponse> {
    return this.httpClient.put<EditarCursoResponse>(`${this.apiBaseUrl}/${cursoId}`, curso);
  }

  removerCurso(cursoId: number): Observable<void> {
    return this.httpClient.delete<void>(`${this.apiBaseUrl}/${cursoId}`);
  }
}
