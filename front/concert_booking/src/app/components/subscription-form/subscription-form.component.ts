import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { SubscriptionService } from '../../services/subscription.service';
import { PostUser } from '../../models/post_user.model';

@Component({
  selector: 'app-subscription-form',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './subscription-form.component.html',
  styleUrls: ['./subscription-form.component.scss']
})
export class SubscriptionFormComponent implements OnInit {
  email: string = '';
  password: string = '';
  confirmPassword: string = '';
  passwordError: string = '';
  confirmPasswordError: string = '';
  isLoading: boolean = false;
  error: string = '';

  constructor(
    private router: Router,
    private subscriptionService: SubscriptionService
  ) {}

  ngOnInit() {
    // Récupère l'email temporaire s'il existe (pour la landing page)
    // Sinon, laisse le champ vide pour saisie manuelle (pour le header)
    const tempEmail = this.subscriptionService.getTempEmail();
    if (tempEmail) {
      this.email = tempEmail;
    }
  }

  hasTempEmail(): boolean {
    return !!this.subscriptionService.getTempEmail();
  }

  validatePassword() {
    this.passwordError = '';
    this.confirmPasswordError = '';

    if (this.password.length < 8) {
      this.passwordError = 'Password must be at least 8 characters long';
      return false;
    }

    if (!/[A-Z]/.test(this.password)) {
      this.passwordError = 'Password must contain at least one uppercase letter';
      return false;
    }

    if (!/[a-z]/.test(this.password)) {
      this.passwordError = 'Password must contain at least one lowercase letter';
      return false;
    }

    if (!/[0-9]/.test(this.password)) {
      this.passwordError = 'Password must contain at least one number';
      return false;
    }

    if (this.password !== this.confirmPassword) {
      this.confirmPasswordError = 'Passwords do not match';
      return false;
    }

    return true;
  }

  validateEmail(): boolean {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(this.email);
  }

  isFormValid(): boolean {
    return this.email.length > 0 &&
           this.validateEmail() &&
           this.password.length > 0 &&
           this.confirmPassword.length > 0 &&
           !this.passwordError &&
           !this.confirmPasswordError;
  }

  submitSubscription() {
    if (!this.validatePassword()) {
      return;
    }

    this.isLoading = true;
    this.error = '';

    const userData: PostUser = {
      email: this.email,
      plain_password: this.password
    };

    console.log('Submitting user data:', userData);

    this.subscriptionService.createUser(userData).subscribe({
      next: (response) => {
        console.log('User created successfully:', response);
        if (this.hasTempEmail()) {
          this.subscriptionService.clearTempEmail();
        }
        this.router.navigate(['/'], {
          queryParams: {
            registered: 'true'
          }
        });
      },
      error: (err) => {
        console.error('Registration error:', err);
        this.error = err.error?.message || 'Failed to create account. Please try again later.';
        this.isLoading = false;
      }
    });
  }

  cancel() {
    if (this.hasTempEmail()) {
      this.subscriptionService.clearTempEmail();
    }
    this.router.navigate(['/']);
  }
}
