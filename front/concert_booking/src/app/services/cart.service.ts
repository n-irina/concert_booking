import { Injectable, EventEmitter } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../environment/environment';
import { HttpHeaders } from '@angular/common/http';

export interface CartItem {
  sessionId: number;
  seatTypeName: string;
  quantity: number;
  price: number;
}

@Injectable({ providedIn: 'root' })
export class CartService {
  private cartKey = 'cart_items';
  private cartItems: CartItem[] = [];
  private apiUrl = environment.apiUrl; // must be https://localhost:8000 or http://localhost:8000

  cartChanged = new EventEmitter<void>();

  constructor(private http: HttpClient) {
    this.loadCartFromStorage();
  }

  private loadCartFromStorage(): void {
    const storedCart = localStorage.getItem(this.cartKey);
    if (storedCart) {
      this.cartItems = JSON.parse(storedCart);
    }
  }

  private saveCartToStorage(): void {
    localStorage.setItem(this.cartKey, JSON.stringify(this.cartItems));
  }

  getCartItems(): CartItem[] {
    return this.cartItems;
  }

  addToCart(item: CartItem): void {
    this.cartItems.push(item);
    this.saveCartToStorage();
    this.cartChanged.emit();
  }

  removeFromCart(index: number): void {
    this.cartItems.splice(index, 1);
    this.saveCartToStorage();
    this.cartChanged.emit();
  }

  clearCart(): void {
    this.cartItems = [];
    this.saveCartToStorage();
    this.cartChanged.emit();
  }

  getTotal(): number {
    return this.cartItems.reduce((total: number, item: CartItem) => total + (item.price * item.quantity), 0);
  }

  getCartUpdated(): EventEmitter<void> {
    return this.cartChanged;
  }

  payCart(cartItems: CartItem[]): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json'
    });
    return this.http.post(`${this.apiUrl}/bookings/batch`, JSON.stringify({ items: cartItems }), { headers });
  }
}
