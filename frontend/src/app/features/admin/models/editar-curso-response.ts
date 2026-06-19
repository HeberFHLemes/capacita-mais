import { Curso } from '../../cursos/models/curso';

export interface EditarCursoResponse {
  editado: boolean;
  curso: Curso|null;
  mensagem: string|null;
}
