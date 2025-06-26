import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { AuthService } from '../services/auth.service';

export const authGuard: CanActivateFn = (route, state) => {
  const authService = inject(AuthService);
  const router = inject(Router);

  if (authService.isLoggedIn()) {
    return true;
  } else {
    // Rediriger vers la page de login avec l'URL actuelle comme paramètre de retour
    router.navigate(['/login'], {
      queryParams: {
        redirect: state.url
      }
    });
    return false;
  }
};
