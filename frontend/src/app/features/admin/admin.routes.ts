import { Routes } from '@angular/router';
import { GestaoCursosPage } from './pages/gestao-cursos-page/gestao-cursos-page';
import { GestaoCategoriasPage } from './pages/gestao-categorias-page/gestao-categorias-page';
import { CadastroCursoPage } from './pages/cadastro-curso-page/cadastro-curso-page';
import { EditarCursoPage } from './pages/editar-curso-page/editar-curso-page';
import { CadastroCategoriaPage } from './pages/cadastro-categoria-page/cadastro-categoria-page';
import { EditarCategoriaPage } from './pages/editar-categoria-page/editar-categoria-page';

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
        path: ':id/editar',
        component: EditarCursoPage
      }
    ]
  },
  {
    path: 'categorias',
    children: [
      {
        path: '',
        component: GestaoCategoriasPage
      },
      {
        path: 'nova-categoria',
        component: CadastroCategoriaPage
      },
      {
        path: ':id/editar',
        component: EditarCategoriaPage
      }
    ]
  }
];
