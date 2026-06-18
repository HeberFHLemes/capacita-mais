import { Routes } from '@angular/router';
import { GestaoCursosPage } from './pages/gestao-cursos-page/gestao-cursos-page';
import { GestaoCategoriasPage } from './pages/gestao-categorias-page/gestao-categorias-page';
import { CadastroCursoPage } from './pages/cadastro-curso-page/cadastro-curso-page';
import { EditarCursoPage } from './pages/editar-curso-page/editar-curso-page';

export const ADMIN_ROUTES: Routes = [
  {
    path: '',
    redirectTo: 'cursos',
    pathMatch: 'full'
  },
  {
    path: 'cursos',
    children: [
      {
        path: '',
        component: GestaoCursosPage
      },
      {
        path: 'novo-curso',
        component: CadastroCursoPage
      },
      {
        path: 'editar',
        component: EditarCursoPage
      }
    ]
  },
  {
    path: 'categorias',
    component: GestaoCategoriasPage
  }
];
