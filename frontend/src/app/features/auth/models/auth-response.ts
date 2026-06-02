import { Usuario } from "./usuario";

export interface AuthResponse {
  token: string;
  usuario: Usuario;
}
