import { Routes } from '@angular/router';
import { CadastroCursoPage } from './pages/cadastro-curso-page/cadastro-curso-page';
import { LoginPage } from './pages/login-page/login-page';

/*
 * TODO:
 * configurar se logado redicionar para cadastro/dashboard futuramente,
 * se não logado, redirecionar para login
 * */
export const ADMIN_ROUTES: Routes = [
  {
    path: '',
    component: LoginPage,
  },
  {
    path: 'cadastro',
    component: CadastroCursoPage
  },
];
