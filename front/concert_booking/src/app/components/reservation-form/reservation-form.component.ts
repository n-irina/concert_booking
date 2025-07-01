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
  ],
  templateUrl: './reservation-form.component.html',
  styleUrl: './reservation-form.component.scss'
})
export class ReservationFormComponent {

  @Input() sessions: Session[] = [];
  @Input() quantities: number[] = [0, 1, 2, 3, 4, 5];
  @Output() reservationConfirmed = new EventEmitter<any>();

  selectedSession: Session | null = null;
  seatTypeSelections: { [seatTypeId: number]: boolean } = {}; // Boolean for each seat type
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
    this.seatTypeSelections = {}; // Reset selections
    this.initializeQuantities();
    this.updateTotal();
  }

  initializeQuantities(): void {
    if (this.selectedSession) {
      this.seatQuantities = {};
      this.seatTypeSelections = {};
      // Initialize all quantities to 0 and selections to false
      this.selectedSession.sessionSeatTypes.forEach(seat => {
        this.seatQuantities[seat.seat_type.id] = 0;
        this.seatTypeSelections[seat.seat_type.id] = false;
        console.log(`Initialized seat type ${seat.seat_type.id}: quantity=${this.seatQuantities[seat.seat_type.id]}, selected=${this.seatTypeSelections[seat.seat_type.id]}`);
      });
    }
  }

  onSeatTypeChange(i: number): void {
    // If checkbox is unchecked, reset quantity to 0
    if (!this.seatTypeSelections[i]) {
      this.seatQuantities[i] = 0;
    } else {
      // If checked, set quantity to 1 if it was 0
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

  // Update seat quantity and toggle selection
  updateQuantity(seatTypeId: number, quantity: number): void {
    console.log(`updateQuantity called for seat type ${seatTypeId} with quantity ${quantity}`);
    console.log('Current seatTypeSelections:', this.seatTypeSelections);
    console.log('Current seatQuantities:', this.seatQuantities);

    // If quantity is 0, uncheck the checkbox
    if (quantity === 0) {
      this.seatTypeSelections[seatTypeId] = false;
      console.log(`Set seat type ${seatTypeId} to unselected because quantity is 0`);
    }

    // Update quantity (already done by ngModel)
    this.seatQuantities[seatTypeId] = quantity;
    console.log(`Updated seatQuantities[${seatTypeId}] to ${quantity}`);

    // Recalculate total
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

  // Confirm reservation and add to cart
  confirmReservation(): void {
    console.log('Confirm reservation button clicked');
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
      // Optional: display message or redirect to cart
      alert('Reservation added to cart!');
    }
  }
}
