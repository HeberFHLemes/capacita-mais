import { Perfil } from "./perfil";

export interface Usuario {
  id: number;
  nome: string;
  perfil: Perfil;
  dataCriacao: string; // converter no uso
}
