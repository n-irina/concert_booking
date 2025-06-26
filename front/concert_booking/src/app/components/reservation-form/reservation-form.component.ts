import { Component, Input, Output, EventEmitter } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Session } from '../../models/session.model';
import { DatePipe, NgFor, NgIf, NgClass, JsonPipe } from '@angular/common';
import { CartService, CartItem } from '../../services/cart.service';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-reservation-form',
  standalone: true,
  imports: [
    FormsModule,
    NgIf,
    NgFor,
    NgClass,
    DatePipe,
    JsonPipe,
  ],
  templateUrl: './reservation-form.component.html',
  styleUrl: './reservation-form.component.scss'
})
export class ReservationFormComponent {

  @Input() sessions: Session[] = [];
  @Input() quantities: number[] = [0, 1, 2, 3, 4, 5];
  @Output() reservationConfirmed = new EventEmitter<any>();

  selectedSession: Session | null = null;
  seatTypeSelections: { [seatTypeId: number]: boolean } = {}; // Booléen pour chaque type de siège
  seatQuantities: { [seatTypeId: number]: number } = {};
  totalAmount: number = 0;

  constructor(
    private cartService: CartService,
    private authService: AuthService,
    private router: Router
  ) {}

  ngOnInit(): void {
    console.log('ReservationFormComponent ngOnInit called');
    console.log('Sessions received:', this.sessions);

    if (this.sessions.length > 0) {
      this.selectedSession = this.sessions[0];
      console.log('Selected session:', this.selectedSession);
      this.initializeQuantities();
    }
  }

  onSelectSession(sessionId: number): void {
    this.selectedSession = this.sessions.find(s => s.id === +sessionId) || null;
    this.seatTypeSelections = {}; // Réinitialiser les sélections
    this.initializeQuantities();
    this.updateTotal();
  }

  initializeQuantities(): void {
    if (this.selectedSession) {
      this.seatQuantities = {};
      this.seatTypeSelections = {};
      // Initialiser toutes les quantités à 0 et sélections à false
      this.selectedSession.sessionSeatTypes.forEach(seat => {
        this.seatQuantities[seat.seat_type.id] = 0;
        this.seatTypeSelections[seat.seat_type.id] = false;
        console.log(`Initialized seat type ${seat.seat_type.id}: quantity=${this.seatQuantities[seat.seat_type.id]}, selected=${this.seatTypeSelections[seat.seat_type.id]}`);
      });
    }
  }

  onSeatTypeChange(i: number): void {
    // Si la case est décochée, remettre la quantité à 0
    if (!this.seatTypeSelections[i]) {
      this.seatQuantities[i] = 0;
    } else {
      // Si cochée, mettre la quantité à 1 si elle était à 0
      if (this.seatQuantities[i] === 0) {
        this.seatQuantities[i] = 1;
      }
    }
    this.updateTotal();
  }

  isSeatTypeSelected(seatTypeId: number): boolean {
    const isSelected = this.seatTypeSelections[seatTypeId] || false;
    console.log(`Checking if seat type ${seatTypeId} is selected:`, isSelected);
    return isSelected;
  }

  updateQuantity(seatTypeId: number, quantity: number): void {
    console.log(`updateQuantity called for seat type ${seatTypeId} with quantity ${quantity}`);
    console.log('Current seatTypeSelections:', this.seatTypeSelections);
    console.log('Current seatQuantities:', this.seatQuantities);

    // Si la quantité est 0, décocher la checkbox
    if (quantity === 0) {
      this.seatTypeSelections[seatTypeId] = false;
      console.log(`Set seat type ${seatTypeId} to unselected because quantity is 0`);
    }

    // Mettre à jour la quantité (déjà fait par ngModel)
    this.seatQuantities[seatTypeId] = quantity;
    console.log(`Updated seatQuantities[${seatTypeId}] to ${quantity}`);

    // Recalculer le total
    this.updateTotal();
  }

  updateTotal(): void {
    this.totalAmount = 0;
    if (this.selectedSession) {
      this.selectedSession.sessionSeatTypes.forEach((seat, i) => {
        const quantity = this.seatQuantities[i];
        if (quantity && quantity > 0) {
          this.totalAmount += seat.price * quantity;
        }
      });
    }
  }

  confirmReservation(): void {
    console.log('Bouton confirmReservation cliqué');
    if (this.selectedSession) {
      this.selectedSession.sessionSeatTypes.forEach((seat, i) => {
        const quantity = this.seatQuantities[i];
        if (this.seatTypeSelections[i] && quantity > 0) {
          const item: CartItem = {
            sessionId: this.selectedSession!.id,
            seatTypeName: seat.seat_type.name,
            quantity,
            price: seat.price
          };
          this.cartService.addToCart(item);
        }
      });
      // Optionnel : afficher un message ou rediriger vers le panier
      alert('Réservation ajoutée au panier !');
    }
  }
}
