import { Routes } from "@angular/router";
import { LoginPage } from "./pages/login-page/login-page"
import { CadastroPage } from "./pages/cadastro-page/cadastro-page";

export const AUTH_ROUTES: Routes = [
  {
    path: 'login',
    component: LoginPage
  },
  {
    path: 'cadastro',
    component: CadastroPage
  }
];
