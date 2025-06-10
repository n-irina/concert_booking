import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { Session } from '../../models/session.model';
import { GetSessionsService } from '../../services/get-sessions.service';
import { Api } from '../../models/api.model';
import { DatePipe, NgClass, NgFor, NgIf, UpperCasePipe } from '@angular/common';
import { Event_api } from '../../models/event_api.model';
import { FormatCategoriesPipe } from '../../pipes/format-categories.pipe';
import { Category } from '../../models/category.model';
import { EventSharedService } from '../../services/event-shared.service';
import { FormatArtistsPipe } from '../../pipes/format-artists.pipe';
import { Hall } from '../../models/hall.model';
import { FormsModule } from '@angular/forms';
import { HeaderComponent } from "../header/header.component";
import { FooterComponent } from "../footer/footer.component";
import { ReservationFormComponent } from '../reservation-form/reservation-form.component';

@Component({
  selector: 'app-session-detail',
  standalone: true,
  imports: [
    NgIf,
    NgFor,
    NgClass,
    DatePipe,
    FormatCategoriesPipe,
    UpperCasePipe,
    FormatArtistsPipe,
    FormsModule,
    HeaderComponent,
    FooterComponent,
    ReservationFormComponent,
],
  templateUrl: './session-detail.component.html',
  styleUrl: './session-detail.component.scss'
})
export class SessionDetailComponent implements OnInit{

  session: Session[] = [];
  event: Event_api | undefined;
  hallName: string | null = null;
  categories: Category[] = [];
  minimum_price: number = 0;
  hall: Hall | undefined;
  showInfo: boolean = false;
  showResa: boolean = false;
  selectedSession: Session | null = null;

  constructor(
    private session_service: GetSessionsService,
    private shared_service: EventSharedService,
    private activatedRoute: ActivatedRoute,
    private router: Router,
  ){ }

  ngOnInit(): void {
    const sessionId = this.activatedRoute.snapshot.params['sessionId'];

    if (sessionId) {
      this.session_service.getSessionById(sessionId).subscribe(
        (res: Session) => {
          this.session = [res]; // Wrap in array since component expects array
          this.event = res.event;
          this.categories = this.shared_service.getCategories();
          this.minimum_price = this.getMinimumPrice(this.session);
          this.hall = res.hall;
          this.hallName = this.hall?.name || null;
        },
        (error) => {
          console.error("Error fetching session", error);
          this.router.navigate(['/']);
        }
      );
    } else {
      console.error("Missing session ID");
      this.router.navigate(['/']);
    }
  }

  getMinimumPrice(sessions: Session[]): number{
    let price: number = Infinity;
    for(const session of sessions){
      for(const seat of session.sessionSeatTypes){
        if(seat.price<price){
          price = seat.price;
        }
      }
    }
    return price;
  }

  showInformation(){
    this.showInfo = true;
  }

  closeInformation(){
    this.showInfo = false;
  }

  showReservation(){
    this.showResa = true;
  }

  onSelectSession(sessionId: number): void {
    this.selectedSession = this.session.find(s => s.id === +sessionId) || null;
  }

  handleReservation(reservation: { sessionId: number, seatTypeId: number, quantity: number }) {
    console.log('Reservation done:', reservation);
    // Tu peux ensuite envoyer la réservation à ton API ou autre
  }

}
