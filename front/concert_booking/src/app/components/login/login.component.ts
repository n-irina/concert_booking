import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router, ActivatedRoute } from '@angular/router';
import { AuthService, LoginCredentials } from '../../services/auth.service';
import { Observable, of } from 'rxjs';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './login.component.html',
  styleUrl: './login.component.scss'
})
export class LoginComponent {
  credentials: LoginCredentials = {
    email: '',
    password: ''
  };

  isLoading = false;
  error = '';
  redirectUrl: string = '/';

  constructor(
    private authService: AuthService,
    private router: Router,
    private route: ActivatedRoute
  ) {
    // Récupérer l'URL de redirection depuis les paramètres de requête
    this.route.queryParams.subscribe(params => {
      this.redirectUrl = params['redirect'] || '/';
    });
  }

  onSubmit(): void {
    console.log('onSubmit called');
    if (!this.credentials.email || !this.credentials.password) {
      this.error = 'Please fill in all fields';
      return;
    }

    this.isLoading = true;
    this.error = '';

    console.log('Submitting login form:', this.credentials);

    this.authService.login(this.credentials).subscribe({
      next: (response: any) => {
        // Log complet de la réponse pour debug
        console.log('=== LOGIN API RESPONSE ===');
        console.log(response);
        this.isLoading = false;
        // Debug : afficher la structure de la réponse et des rôles
        console.log('Login response:', response);
        console.log('Roles:', response.user?.roles, response.roles);
        // Rediriger selon le rôle
        const roles = response.user?.roles || response.roles || [];
        if (roles.includes('ROLE_ADMIN')) {
          this.router.navigate(['/admin']);
        } else {
          this.router.navigate([this.redirectUrl]);
        }
      },
      error: (err: any) => {
        console.error('Login error:', err);
        this.isLoading = false;
        this.error = err.error?.message || 'Login failed. Please check your credentials.';
      }
    });
  }

  cancel(): void {
    this.router.navigate(['/']);
  }
}
