import { HttpInterceptorFn } from '@angular/common/http';
import { AUTH_TOKEN_KEY } from '../constants/auth-constants';

export const authInterceptor: HttpInterceptorFn = (
  req,
  next
) => {
  // Injeção do AuthService causava circular dependency:
  // (Esse interceptor -> AuthService -> AuthApiService -> HttpClient -> esse interceptor)
  // const authService: AuthService = inject(AuthService);
  // const token = authService.getToken();
  const token = localStorage.getItem(AUTH_TOKEN_KEY);

  const cloned = token
    ? req.clone({ setHeaders: { Authorization: `Bearer  ${token}` } })
    : req;

  return next(cloned);
};
