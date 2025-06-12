import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { HeaderComponent } from '../header/header.component';
import { SubscriptionService } from '../../services/subscription.service';

@Component({
  selector: 'app-landing-page',
  standalone: true,
  imports: [
    CommonModule,
    FormsModule,
    HeaderComponent
  ],
  templateUrl: './landing-page.component.html',
  styleUrl: './landing-page.component.scss'
})
export class LandingPageComponent {
  email: string = '';
  emailError: string = '';
  isLoading: boolean = false;

  constructor(
    private router: Router,
    private subscriptionService: SubscriptionService
  ) {}

  validateEmail(email: string): boolean {
    const emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return emailRegex.test(email);
  }

  goToSubscriptionForm() {
    if (!this.email) {
      this.emailError = 'Email is required';
      return;
    }

    if (!this.validateEmail(this.email)) {
      this.emailError = 'Please enter a valid email';
      return;
    }

    this.isLoading = true;
    this.emailError = '';

    // Store email in service
    this.subscriptionService.setTempEmail(this.email);

    // Navigate to subscription form
    this.router.navigate(['/subscription-form']);
  }
}
