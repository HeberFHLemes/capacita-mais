import { Routes } from '@angular/router';
import { CadastroCursoPage } from './pages/cadastro-curso-page/cadastro-curso-page';

export const ADMIN_ROUTES: Routes = [
  /* TODO:
   * 1 - Layout inicial da área adminstrativa
   * 2 - Página de gestão de cursos
   * 3 - Página de gestão de categorias
   * 4 - Formulários de cadastro e de edição para cursos e para categorias
   * 5 - Aside/nav para navegar entre as seções de categorias e cursos
   *
   * Por enquanto usando esta página CadastroCursoPage para testar guards.
   */
  {
    path: '',
    component: CadastroCursoPage,
  },
  {
    path: 'cadastro',
    component: CadastroCursoPage
  },
];
