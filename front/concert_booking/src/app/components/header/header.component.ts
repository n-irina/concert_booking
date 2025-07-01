import { Component } from '@angular/core';
import { SearchBarComponent } from '../search-bar/search-bar.component';
import { Router, RouterLink } from '@angular/router';
import { CommonModule } from '@angular/common';
import { CartService } from '../../services/cart.service';

@Component({
  selector: 'app-header',
  standalone: true,
  imports: [
    SearchBarComponent,
    RouterLink,
    CommonModule
  ],
  templateUrl: './header.component.html',
  styleUrl: './header.component.scss'
})
export class HeaderComponent {
  cartItemCount: number = 0;

  
  constructor(private router: Router, private cartService: CartService) {
    this.updateCartCount();
    this.cartService.getCartUpdated().subscribe(() => {
      this.updateCartCount();
    });
  }

  updateCartCount(): void {
    this.cartItemCount = this.cartService.getCartItems().length;
  }


  isMenuOpen = false;

  toggleMenu() {
    this.isMenuOpen = !this.isMenuOpen;
  }

  goToSubscriptionForm(): void {
    this.router.navigate(['/subscription-form']);
  }

  onSearch(searchTerm: string): void {
    // → Call your service / local filter / route, etc.
    console.log('Search term:', searchTerm);
  }
}
