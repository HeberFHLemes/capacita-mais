import { bootstrapApplication } from '@angular/platform-browser';
import { appConfig } from './app/app.config';
import { App } from './app/app';
import { AuthService } from './app/features/auth/services/auth-service';

bootstrapApplication(App, appConfig)
  .then(app => {
    app.injector.get(AuthService);
  })
  .catch((err) => console.error(err))
