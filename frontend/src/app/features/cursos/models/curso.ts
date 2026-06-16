import { Categoria } from "../../categorias/models/categoria";

export interface Curso {
  id: number;
  nome: string;
  descricao?: string;
  categoria: Categoria;
  nivel: string;
  preco: number;
  preco_original: number;
  em_destaque: boolean;
}
