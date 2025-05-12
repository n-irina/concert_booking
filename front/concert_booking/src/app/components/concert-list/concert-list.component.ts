import { Component } from '@angular/core';
import { Event_api } from '../../models/event_api.model';
import { GetEventsService } from '../../services/get-events.service';
import { Router } from '@angular/router';
import { Api } from '../../models/api.model';
import { NgIf } from '@angular/common';
import { CardListComponent } from '../card-list/card-list.component';
import { HeaderComponent } from "../header/header.component";
import { FooterComponent } from "../footer/footer.component";

@Component({
  selector: 'app-concert-list',
  standalone: true,
  imports: [
    NgIf,
    CardListComponent,
    HeaderComponent,
    FooterComponent
],
  templateUrl: './concert-list.component.html',
  styleUrl: './concert-list.component.scss'
})
export class ConcertListComponent {

  future_events: Event_api[] = [];

  constructor(
    private event_service: GetEventsService,
    private router: Router,
  ){ }


  ngOnInit(): void {
    this.event_service.getFutureEvents().subscribe(
      (res: Api<Event_api>) => {
        const allEvents = res['member'];
        this.future_events = this.getRandomEvents(allEvents);
      },
      (error) => {
        console.error("Error fetching future events", error);
      }
    );
  }

  getRandomEvents(array: Event_api[]): Event_api[] {
    return [...array]
      .sort(() => 0.5 - Math.random())
  }

}
