import { CanActivateFn, Router } from '@angular/router';
import { inject } from '@angular/core';
import { AuthService } from '../services/auth-service';

export const adminGuard: CanActivateFn = (
  route,
  state
) => {

  const authService = inject(AuthService);
  const router = inject(Router);

  if (!authService.isUsuarioAutenticado()) {
    return router.createUrlTree(
      ['/login'],
      { queryParams: { returnUrl: state.url } }
    );
  }

  if (!authService.isAdmin()) {
    return router.createUrlTree(['/acesso-negado']);
  }

  return true;
};
