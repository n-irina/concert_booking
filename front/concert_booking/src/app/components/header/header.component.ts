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
  cartCount = 0;

  constructor(private router: Router, private cartService: CartService) {
    this.updateCartCount();
    window.addEventListener('storage', () => this.updateCartCount());
    this.cartService.cartChanged.subscribe(() => this.updateCartCount());
  }

  updateCartCount() {
    this.cartCount = this.cartService.getCartItems().length;
  }

  isMenuOpen = false;

  toggleMenu() {
    this.isMenuOpen = !this.isMenuOpen;
  }

  goToSubscriptionForm() {
    this.router.navigate(['subscription-form']);
  }

  onSearch(query: string) {
    console.log('Recherche :', query);
    // → Appel à ton service / filtre local / route, etc.
  }
}
