import { Component, OnInit } from '@angular/core';
import { Event_api } from '../../models/event_api.model';
import { GetEventsService } from '../../services/get-events.service';
import { ActivatedRoute, Router } from '@angular/router';
import { DatePipe, KeyValuePipe, NgFor, NgIf, UpperCasePipe } from '@angular/common';
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
    private event_service: GetEventsService,
    private shared_service: EventSharedService,
    private activatedRoute: ActivatedRoute,
    private router: Router,
  ){ }

  ngOnInit(): void {
    const id: number = +this.activatedRoute.snapshot.params["id"];
    const selectedHall = this.activatedRoute.snapshot.params["hall"];

    this.event_service.getEventById(id).subscribe(
      (res: Event_api) => {
        this.event = res;
        this.grouped_sessions = this.groupSessionsByHall(this.event?.sessions);

        // Si un hall est spécifié dans l'URL, ne garder que les sessions de ce hall
        if (selectedHall && this.grouped_sessions[selectedHall]) {
          const filteredSessions = { [selectedHall]: this.grouped_sessions[selectedHall] };
          this.grouped_sessions = filteredSessions;
        }

        this.minimum_price = this.calculateMinPricesByHall(this.grouped_sessions);
        this.event_category = this.getAllCategories(this.event);
        this.shared_service.setCategories(this.event_category);
      },
      (error) => {
        console.error("Error fetching future events", error);
      }
    );
  }

  groupSessionsByHall(sessions: Session[]) {
    const grouped : { [hall: string]: Session[] } = {};

    for (const session of sessions) {
      if (!grouped[session.hall.name]) {
        grouped[session.hall.name] = [];
      }
      grouped[session.hall.name].push(session);
    }

    return grouped;
  }

  calculateMinPricesByHall(grouped: { [hall: string]: Session[] }): { [hall: string]: number } {
    const prices: { [hall: string]: number } = {};

    for (const hall in grouped) {
      const sessions = grouped[hall];
      let min = Infinity;

      for (const session of sessions) {
        for (const seat of session.sessionSeatTypes || []) {
          if (seat.price < min) {
            min = seat.price;
          }
        }
      }

      prices[hall] = min === Infinity ? 0 : min;
    }

    return prices;
  }


  getAllCategories(event: Event_api): Category[] {
    return event.artist.flatMap(a => a.category);
  }

  goToDetails(hall: string, eventId: string): void {
    // Trouver les sessions pour ce hall et cet événement
    const sessions = this.grouped_sessions[hall];
    if (sessions && sessions.length > 0) {
      // On redirige toujours vers la première session, qui affichera toutes les dates disponibles
      this.router.navigate(['/events', eventId, '/sessions']);
    } else {
      console.error('No session found for this hall and event');
      this.router.navigate(['/']);
    }
  }

}
