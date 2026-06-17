import { inject, Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import {map, Observable} from 'rxjs';
import { CursoMatriculado } from '../models/curso-matriculado';

interface CursoMatriculadoResponse {
  id: number;
  nome: string;
  data_compra: string;
}

@Injectable({
  providedIn: 'root',
})
export class MeusCursosApiService {
  readonly httpClient: HttpClient = inject(HttpClient);

  readonly apiBaseUrl: string = '/api/matriculas';

  buscarMeusCursos(): Observable<CursoMatriculado[]> {
    return this.httpClient.get<CursoMatriculadoResponse[]>(this.apiBaseUrl)
      .pipe(
        map(cursos => cursos.map(
          curso => ({
            id: curso.id,
            nome: curso.nome,
            dataCompra: new Date(curso.data_compra),
          })
        ))
      );
  }
}
