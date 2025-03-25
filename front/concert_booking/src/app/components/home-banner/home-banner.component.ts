import { Component } from '@angular/core';
import { Event_api } from '../../models/event_api.model';
import { GetEventsService } from '../../services/get-events.service';
import { Api } from '../../models/api.model';
import { CommonModule, NgIf } from '@angular/common';

@Component({
  selector: 'app-home-banner',
  standalone: true,
  imports: [
    NgIf,
    CommonModule,
  ],
  templateUrl: './home-banner.component.html',
  styleUrl: './home-banner.component.scss'
})
export class HomeBannerComponent {

  future_events: Event_api[] = [];

  constructor(
    private event_service: GetEventsService,
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

prev() {
  this.currentIndex = (this.currentIndex - 1 + this.future_events.length) % this.future_events.length;
}

next() {
  this.currentIndex = (this.currentIndex + 1) % this.future_events.length;
}

}
