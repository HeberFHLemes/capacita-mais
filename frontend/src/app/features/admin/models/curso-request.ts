export interface CursoRequest {
  nome: string;
  descricao: string|null;
  categoria_id: number;
  nivel: 'iniciante'|'intermediario'|'avancado';
  preco: number;
  preco_original: number;
  em_destaque: boolean;
}
