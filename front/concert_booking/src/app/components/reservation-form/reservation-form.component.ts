import { Component, Input, Output, EventEmitter } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { Session } from '../../models/session.model';
import { DatePipe, NgFor, NgIf } from '@angular/common';

@Component({
  selector: 'app-reservation-form',
  standalone: true,
  imports: [
    FormsModule,
    NgIf,
    NgFor,
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
  selectedSeatTypeId: number | null = null;
  seatQuantities: { [seatTypeId: number]: number } = {};
  totalAmount: number = 0;

  ngOnInit(): void {
    if (this.sessions.length > 0) {
      this.selectedSession = this.sessions[0];
      this.initializeQuantities();
    }
  }

  onSelectSession(sessionId: number): void {
    this.selectedSession = this.sessions.find(s => s.id === +sessionId) || null;
    this.selectedSeatTypeId = null;
    this.initializeQuantities();
    this.updateTotal();
  }

  initializeQuantities(): void {
    if (this.selectedSession) {
      this.seatQuantities = {};
      // Initialiser toutes les quantités à 0
      this.selectedSession.sessionSeatTypes.forEach(seat => {
        this.seatQuantities[seat.seat_type.id] = 0;
      });
    }
  }

  onSeatTypeChange(seatTypeId: number): void {
    if (this.selectedSeatTypeId === seatTypeId) {
      // Si on déselectionne la checkbox
      this.selectedSeatTypeId = null;
      this.seatQuantities[seatTypeId] = 0;
    } else {
      // Si on sélectionne la checkbox
      this.selectedSeatTypeId = seatTypeId;
      this.seatQuantities[seatTypeId] = 1;
    }
    this.updateTotal();
  }

  getQuantityForSeat(seatTypeId: number): number {
    return this.seatQuantities[seatTypeId] || 0;
  }

  updateQuantity(seatTypeId: number, quantity: number): void {
    if (seatTypeId === this.selectedSeatTypeId) {
      if (quantity === 0) {
        this.selectedSeatTypeId = null;
      }
      this.seatQuantities[seatTypeId] = quantity;
      this.updateTotal();
    }
  }

  updateTotal(): void {
    this.totalAmount = 0;
    if (this.selectedSession) {
      for (const seatType of this.selectedSession.sessionSeatTypes) {
        const quantity = this.seatQuantities[seatType.seat_type.id];
        if (quantity && quantity > 0) {
          this.totalAmount += seatType.price * quantity;
        }
      }
    }
  }

  confirmReservation(): void {
    if (this.selectedSession) {
      const reservations = [];
      for (const seatType of this.selectedSession.sessionSeatTypes) {
        const quantity = this.seatQuantities[seatType.seat_type.id];
        if (quantity && quantity > 0) {
          reservations.push({
            sessionId: this.selectedSession.id,
            seatTypeId: seatType.seat_type.id,
            quantity,
            total: seatType.price * quantity
          });
        }
      }
      if (reservations.length > 0) {
        this.reservationConfirmed.emit(reservations);
      }
    }
  }
}
