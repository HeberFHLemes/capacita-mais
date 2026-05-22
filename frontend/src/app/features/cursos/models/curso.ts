export interface Curso {
  id: number;
  nome: string;
  descricao?: string;
  custo: number;
  categoria: string;
  url: string | URL;
};
