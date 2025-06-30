import { Component } from '@angular/core';
import { CartService, CartItem } from '../../services/cart.service';
import { DecimalPipe, NgFor, NgIf } from '@angular/common';
import { Router } from '@angular/router';

@Component({
  selector: 'app-cart',
  templateUrl: './cart.component.html',
  styleUrl: './cart.component.scss',
  standalone: true,
  imports: [
    DecimalPipe,
    NgIf,
    NgFor,
  ]
})
export class CartComponent {
  cartItems: CartItem[] = [];

  constructor(private cartService: CartService, private router: Router) {
    this.loadCart();
  }

  loadCart() {
    this.cartItems = this.cartService.getCartItems();
  }

  removeItem(index: number) {
    this.cartService.removeFromCart(index);
    this.loadCart();
  }

  clearCart() {
    this.cartService.clearCart();
    this.loadCart();
  }

  getTotal(): number {
    return this.cartItems.reduce((sum, item) => sum + item.price * item.quantity, 0);
  }

  payCart() {
    this.cartService.payCart(this.cartItems).subscribe({
      next: () => {
        alert('Booking confirmed!');
        this.clearCart();
        this.loadCart();
        this.router.navigate(['/']);
      },
      error: () => {
        alert('An error occurred during payment.');
      }
    });
  }
}
