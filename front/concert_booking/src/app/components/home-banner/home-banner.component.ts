import { Component } from '@angular/core';
import { Event_api } from '../../models/event_api.model';
import { GetEventsService } from '../../services/get-events.service';
import { Api } from '../../models/api.model';
import { CommonModule, DatePipe, NgIf } from '@angular/common';
import { FormatArtistsPipe } from '../../pipes/format-artists.pipe';
import { Router } from '@angular/router';

@Component({
  selector: 'app-home-banner',
  standalone: true,
  imports: [
    NgIf,
    CommonModule,
    FormatArtistsPipe,
  ],
  templateUrl: './home-banner.component.html',
  styleUrl: './home-banner.component.scss'
})
export class HomeBannerComponent {

  future_events: Event_api[] = [];

  constructor(
    private event_service: GetEventsService,
    private router: Router,
  ){ }


  ngOnInit(): void {
    this.event_service.getFutureEvents().subscribe(
      (res: Api<Event_api>) => {
        const allEvents = res['member'];
        this.future_events = this.getRandomEvents(allEvents, 3);
        console.log(this.future_events)
      },
      (error) => {
        console.error("Error fetching future events", error);
      }
    );
  }

  getRandomEvents(array: Event_api[], count: number): Event_api[] {
    return [...array]
      .sort(() => 0.5 - Math.random())
      .slice(0, count);
  }

  currentIndex: number = 0;

  next() {
    this.currentIndex = (this.currentIndex + 1) % this.future_events.length;
  }

  prev() {
    this.currentIndex = (this.currentIndex - 1 + this.future_events.length) % this.future_events.length;
  }


  goToConcertDetail(id: number): void {
    // const event = this.future_events[this.currentIndex];
    // const artist = event.artist[0]; // tu peux adapter si plusieurs artistes

    // if (event && artist) {
    //   this.router.navigate(['/concert', event.id], {
    //     queryParams: { artistId: artist.id } // on passe l’id dans l’URL
    //   });
    // }
    this.router.navigate(['/concert/'+ id]);
  }

}
