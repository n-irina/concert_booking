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
  private apiUrl = environment.apiUrl; // doit être https://localhost:8000 ou http://localhost:8000


  cartChanged = new EventEmitter<void>();

  constructor(private http: HttpClient) {}

  getCartItems(): CartItem[] {
    const items = localStorage.getItem(this.cartKey);
    return items ? JSON.parse(items) : [];
  }

  addToCart(item: CartItem): void {
    const items = this.getCartItems();
    items.push(item);
    localStorage.setItem(this.cartKey, JSON.stringify(items));
    this.cartChanged.emit();
  }

  removeFromCart(index: number): void {
    const items = this.getCartItems();
    items.splice(index, 1);
    localStorage.setItem(this.cartKey, JSON.stringify(items));
    this.cartChanged.emit();
  }

  clearCart(): void {
    localStorage.removeItem(this.cartKey);
    this.cartChanged.emit();
  }


  payCart(cartItems: CartItem[]): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json'
    });
    return this.http.post(`${this.apiUrl}/bookings/batch`, JSON.stringify({ items: cartItems }), { headers });
  }
}
