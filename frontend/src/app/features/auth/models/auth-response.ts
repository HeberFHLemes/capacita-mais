import { UsuarioAuth } from "./usuario-auth";

export interface AuthResponse {
  token: string;
  usuario: UsuarioAuth;
}
