import {Curso} from '../../cursos/models/curso';

export interface CadastrarCursoResponse {
  criado: boolean;
  curso: Curso;
}
