import { Component, OnInit } from '@angular/core';
import { Event_api } from '../../models/event_api.model';
import { GetSessionsService } from '../../services/get-sessions.service';
import { ActivatedRoute, Router } from '@angular/router';
import { DatePipe, KeyValuePipe, NgFor, NgIf, UpperCasePipe, JsonPipe } from '@angular/common';
import { FormatArtistsPipe } from '../../pipes/format-artists.pipe';
import { Session } from '../../models/session.model';
import { Category } from '../../models/category.model';
import { FormatCategoriesPipe } from '../../pipes/format-categories.pipe';
import { EventSharedService } from '../../services/event-shared.service';
import { Hall } from '../../models/hall.model';
import { HeaderComponent } from "../header/header.component";
import { FooterComponent } from "../footer/footer.component";
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-concert-detail',
  standalone: true,
  imports: [
    NgIf,
    NgFor,
    FormatArtistsPipe,
    KeyValuePipe,
    DatePipe,
    UpperCasePipe,
    FormatCategoriesPipe,
    JsonPipe,
    HeaderComponent,
    FooterComponent,
    RouterLink
],
  templateUrl: './concert-detail.component.html',
  styleUrl: './concert-detail.component.scss'
})
export class ConcertDetailComponent implements OnInit{

  event: Event_api | undefined;
  grouped_sessions:{ [hall: string]: Session[] } = {};
  minimum_price: { [hall: string]: number } = {};
  event_category: Category[] = [];

  constructor(
    private session_service: GetSessionsService,
    private shared_service: EventSharedService,
    private activatedRoute: ActivatedRoute,
    private router: Router,
  ){
    console.log('ConcertDetailComponent constructor called');
  }

  ngOnInit(): void {
    this.activatedRoute.params.subscribe(params => {
      const eventId = params['eventId'] || params['id']; // Support both eventId and id parameters
      console.log('Event ID from params:', eventId);
      if (eventId) {
        this.session_service.getSessionsByEventId(eventId).subscribe({
          next: (sessions: Session[]) => {
            console.log('Sessions received:', sessions);
            if (sessions.length > 0) {
              this.event = sessions[0].event;
              console.log('Event extracted:', this.event);
              console.log('Event artists:', this.event?.artist);
              this.groupSessionsByHall(sessions);
              this.calculateMinimumPrices();
              this.getEventCategories();
            }
          },
          error: (error: any) => {
            console.error('Error fetching sessions:', error);
            this.router.navigate(['/']);
          }
        });
      } else {
        this.router.navigate(['/']);
      }
    });
  }

  groupSessionsByHall(sessions: Session[]): void {
    this.grouped_sessions = {};

    sessions.forEach(session => {
      const hallName = session.hall.name;
      if (!this.grouped_sessions[hallName]) {
        this.grouped_sessions[hallName] = [];
      }
      this.grouped_sessions[hallName].push(session);
    });
  }

  calculateMinimumPrices(): void {
    this.minimum_price = {};

    Object.keys(this.grouped_sessions).forEach(hallName => {
      let minPrice = Infinity;
      this.grouped_sessions[hallName].forEach(session => {
        session.sessionSeatTypes.forEach(seatType => {
          if (seatType.price < minPrice) {
            minPrice = seatType.price;
          }
        });
      });
      this.minimum_price[hallName] = minPrice === Infinity ? 0 : minPrice;
    });
  }

  getEventCategories(): void {
    if (this.event && this.event.artist && this.event.artist.length > 0) {
      console.log('Event artists:', this.event.artist);
      const categories = this.event.artist.flatMap(artist => artist.category || []);
      console.log('Extracted categories:', categories);
      this.event_category = categories;
      console.log('Final event_category:', this.event_category);
    } else {
      console.log('No event or artists found');
    }
  }

  goToDetails(hallName: string, eventId: string): void {
    // If a hall is specified in the URL, keep only sessions from this hall
    const hallSessions = this.grouped_sessions[hallName];
    if (hallSessions && hallSessions.length > 0) {
      // Find sessions for this hall and this event
      const firstSession = hallSessions[0];
      // Always redirect to the first session, which will display all available dates
      this.router.navigate(['/events', eventId, 'sessions'], {
        queryParams: { hallId: firstSession.hall.id }
      });
    }
  }

}
