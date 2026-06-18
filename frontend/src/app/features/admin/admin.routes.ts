import { Routes } from '@angular/router';
import { GestaoCursosPage } from './pages/gestao-cursos-page/gestao-cursos-page';
import { GestaoCategoriasPage } from './pages/gestao-categorias-page/gestao-categorias-page';

export const ADMIN_ROUTES: Routes = [
  {
    path: '',
    redirectTo: 'cursos',
    pathMatch: 'full'
  },
  {
    path: 'cursos',
    component: GestaoCursosPage
  },{
    path: 'categorias',
    component: GestaoCategoriasPage
  },
];
