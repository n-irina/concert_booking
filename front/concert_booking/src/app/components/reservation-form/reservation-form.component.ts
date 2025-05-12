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
  @Input() quantities: number[] = [1, 2, 3, 4, 5];
  @Output() reservationConfirmed = new EventEmitter<any>();

  selectedSession: Session | null = null;
  selectedSeatTypeId: number | null = null;
  seatQuantities: { [seatTypeId: number]: number } = {};

  ngOnInit(): void {
    if (this.sessions.length > 0) {
      this.selectedSession = this.sessions[0];
    }
  }

  onSelectSession(sessionId: number): void {
    this.selectedSession = this.sessions.find(s => s.id === +sessionId) || null;
    this.selectedSeatTypeId = null;
  }

  getSelectedSeat() {
    return this.selectedSession?.sessionSeatTypes.find(
      seat => seat.seat_type.id === this.selectedSeatTypeId
    );
  }

  confirmReservation(): void {
    const selectedSeat = this.getSelectedSeat();
    const quantity = this.selectedSeatTypeId !== null ? this.seatQuantities[this.selectedSeatTypeId] : null;
    if (selectedSeat && quantity) {
      this.reservationConfirmed.emit({
        sessionId: this.selectedSession?.id,
        seatTypeId: selectedSeat.seat_type.id,
        quantity,
        total: selectedSeat.price * quantity
      });
    }
  }
}