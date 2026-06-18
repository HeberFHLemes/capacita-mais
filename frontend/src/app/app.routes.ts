import { Routes } from '@angular/router';
import { AdminLayout } from './features/admin/layouts/admin-layout/admin-layout';
import { ADMIN_ROUTES } from './features/admin/admin.routes';
import { HOME_ROUTES } from './features/home/home.routes';
import { CURSOS_ROUTES } from './features/cursos/cursos.routes';
import { MATRICULAS_ROUTES } from './features/matriculas/matriculas.routes';
import { AUTH_ROUTES } from './features/auth/auth.routes';
import { NotFoundPage } from './shared/pages/not-found-page/not-found-page';
import { AcessoNegadoPage } from './shared/pages/acesso-negado-page/acesso-negado-page';
import { adminGuard } from './features/auth/guards/admin-guard';

export const routes: Routes = [
  {
    path: 'admin',
    component: AdminLayout,
    children: [
      ...ADMIN_ROUTES,
      { path: '**', component: NotFoundPage }
    ],
    canActivate: [ adminGuard ]
  },
  ...HOME_ROUTES,
  ...CURSOS_ROUTES,
  ...MATRICULAS_ROUTES,
  ...AUTH_ROUTES,
  { path: 'acesso-negado', component: AcessoNegadoPage },
  { path: '**', component: NotFoundPage }
];
