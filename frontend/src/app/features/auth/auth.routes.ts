import { Routes } from "@angular/router";
import { LoginPage } from "./login/pages/login-page/login-page";
import { CadastroPage } from "./cadastro/pages/cadastro-page/cadastro-page";

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
