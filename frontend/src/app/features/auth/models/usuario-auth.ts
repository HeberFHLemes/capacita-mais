import { Perfil } from "./perfil";

export interface UsuarioAuth {
  id: number;
  nome: string;
  perfil: Perfil;
}
