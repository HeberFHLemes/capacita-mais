import { ItemCarrinho } from './item-carrinho';

export interface Carrinho {
  total: number;
  cursos: ItemCarrinho[];
}
