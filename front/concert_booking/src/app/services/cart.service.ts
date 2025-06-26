import { Injectable } from '@angular/core';

export interface CartItem {
  sessionId: number;
  seatTypeName: string;
  quantity: number;
  price: number;
}

@Injectable({ providedIn: 'root' })
export class CartService {
  private storageKey = 'concert_cart';

  getCart(): CartItem[] {
    const data = localStorage.getItem(this.storageKey);
    return data ? JSON.parse(data) : [];
  }

  addToCart(item: CartItem): void {
    const cart = this.getCart();
    cart.push(item);
    localStorage.setItem(this.storageKey, JSON.stringify(cart));
  }

  removeFromCart(index: number): void {
    const cart = this.getCart();
    cart.splice(index, 1);
    localStorage.setItem(this.storageKey, JSON.stringify(cart));
  }

  clearCart(): void {
    localStorage.removeItem(this.storageKey);
  }
}
