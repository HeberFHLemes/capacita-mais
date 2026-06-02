import { Routes } from '@angular/router';
import { CadastroCursoPage } from './pages/cadastro-curso-page/cadastro-curso-page';

/*
 * TODO:
 * configurar se logado redicionar para área administrativa futuramente,
 * e se não logado, redirecionar para login
 * */
export const ADMIN_ROUTES: Routes = [
  {
    path: 'cadastro',
    component: CadastroCursoPage
  },
];
