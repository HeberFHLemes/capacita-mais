import { Routes } from '@angular/router';
import { PublicLayout } from './layouts/public-layout/public-layout';
import { AdminLayout } from './layouts/admin-layout/admin-layout';

import { HOME_ROUTES } from './features/home/home.routes';
import { CURSOS_ROUTES } from './features/cursos/cursos.routes';
import { ADMIN_ROUTES } from './features/admin/admin.routes';
import { NotFoundPage } from './shared/pages/not-found-page/not-found-page';
import { AUTH_ROUTES } from './features/auth/auth.routes';

export const routes: Routes = [
  {
    path: 'admin',
    component: AdminLayout,
    children: [
      ...ADMIN_ROUTES,
      { path: '**', component: NotFoundPage }
    ]
  },
  {
    path: '',
    component: PublicLayout,
    children: [
      ...HOME_ROUTES,
      ...CURSOS_ROUTES,
      ...AUTH_ROUTES,
      { path: '**', component: NotFoundPage }
    ]
  },
];
