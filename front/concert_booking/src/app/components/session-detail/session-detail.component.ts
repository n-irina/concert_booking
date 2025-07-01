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
import { DomSanitizer, SafeHtml } from '@angular/platform-browser';

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
  safeDescription: SafeHtml | null = null;
  minDate: Date | null = null;
  maxDate: Date | null = null;
  selectedSessionId: number | null = null;

  constructor(
    private session_service: GetSessionsService,
    private shared_service: EventSharedService,
    private activatedRoute: ActivatedRoute,
    private router: Router,
    private sanitizer: DomSanitizer
  ){ }

  ngOnInit(): void {
    this.activatedRoute.params.subscribe(params => {
      const concertId = params['id'] || params['eventId'];
      const hallId = params['hallId'];
      if (concertId) {
        this.session_service.getSessionsByEventId(concertId).subscribe(
          (sessions: Session[]) => {
            if (hallId) {
              this.session = sessions.filter(s => String(s.hall.id) === String(hallId));
            } else {
              this.session = sessions;
            }
            this.event = this.session[0]?.event;
            this.hall = this.session[0]?.hall;
            this.hallName = this.hall?.name || null;
            this.categories = this.getAllCategoriesFromEvent(this.event);
            this.minimum_price = this.getMinimumPrice(this.session);
            if (this.event) {
              this.safeDescription = this.sanitizer.bypassSecurityTrustHtml(this.event.description);
            }
            this.computeDateRange();
          },
          (error) => {
            this.router.navigate(['/']);
          }
        );
      } else {
        this.router.navigate(['/']);
      }
    });
  }

  computeDateRange() {
    if (this.session && this.session.length > 0) {
      const dates = this.session.map(s => new Date(s.date_time));
      this.minDate = new Date(Math.min(...dates.map(d => d.getTime())));
      this.maxDate = new Date(Math.max(...dates.map(d => d.getTime())));
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
  }

  getAllCategoriesFromEvent(event?: Event_api): Category[] {
    return Array.isArray(event?.artist)
      ? event.artist.flatMap(a => Array.isArray(a.category) ? a.category : [])
      : [];
  }
}
