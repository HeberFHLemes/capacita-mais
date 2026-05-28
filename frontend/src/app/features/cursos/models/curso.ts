export interface Curso {
  id: number;
  nome: string;
  descricao?: string;
  categoria: string;
  nivel: string;
  preco: number;
  preco_original: number;
  em_destaque: boolean;
};
