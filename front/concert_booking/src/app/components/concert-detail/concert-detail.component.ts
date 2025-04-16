import { Component, OnInit } from '@angular/core';
import { Event_api } from '../../models/event_api.model';
import { GetEventsService } from '../../services/get-events.service';
import { ActivatedRoute, Router } from '@angular/router';
import { DatePipe, KeyValuePipe, NgFor, NgIf, UpperCasePipe } from '@angular/common';
import { FormatArtistsPipe } from '../../pipes/format-artists.pipe';
import { Session } from '../../models/session.model';
import { Hall } from '../../models/hall.model';
import { Category } from '../../models/category.model';

@Component({
  selector: 'app-concert-detail',
  standalone: true,
  imports: [
    NgIf,
    NgFor,
    FormatArtistsPipe,
    KeyValuePipe,
    DatePipe,
    UpperCasePipe
  ],
  templateUrl: './concert-detail.component.html',
  styleUrl: './concert-detail.component.scss'
})
export class ConcertDetailComponent implements OnInit{

  event: Event_api | undefined;
  grouped_sessions:{ [hall: string]: Session[] } = {};
  minimum_price: number = 0;
  event_category: Category[] = [];

  constructor(
    private event_service: GetEventsService,
    private activatedRoute: ActivatedRoute,
  ){ }

  ngOnInit(): void {

    // const eventId = this.route.snapshot.paramMap.get('id');
    // const artistId = this.route.snapshot.queryParamMap.get('artistId');

    // const artistIdParam = this.route.snapshot.queryParamMap.get('artistId');

    // if (artistIdParam) {
    //   const artistId = parseInt(artistIdParam, 10);
    //   this.event_service.getArtistEvents(artistId).subscribe(
    //     (res: Api<Event_api>) =>  {
    //       this.event = res["member"];
    //       console.log("deatil event", this.event)
    //     },
    //     (error) => {
    //       console.error("Error fetching singer", error);
    //     },
    //   );
    // } else {
    //   console.warn('Aucun artistId trouvé dans l’URL');
    // }

    const id: number = +this.activatedRoute.snapshot.params["id"];

    this.event_service.getEventById(id).subscribe(
      (res: Event_api) => {
        this.event = res;
        this.grouped_sessions = this.groupSessionsByHall(this.event?.sessions);
        this.minimum_price = this.getMinimumPrice(this.event?.sessions);
        this.event_category = this.getUniqueCategories(this.event);
        console.log("detail event",this.event_category )
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

  getMinimumPrice(sessions: Session[]): number {
    let minPrice = Infinity;

    for (const session of sessions) {
      for (const seatType of session.sessionSeatTypes || []) {
        if (seatType.price < minPrice) {
          minPrice = seatType.price;
        }
      }
    }

    return minPrice === Infinity ? 0 : minPrice;
  }

  getUniqueCategories(event: Event_api): Category[] {
    const allCategories = event.artist.flatMap(a => a.category);
    const unique = new Map<number, Category>();
    for (const c of allCategories) {
      unique.set(c.id, c);
    }
    return Array.from(unique.values());
  }


}
