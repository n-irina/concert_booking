import { Component, OnInit } from '@angular/core';
import { HeaderComponent } from '../header/header.component';
import { FooterComponent } from '../footer/footer.component';
import { Event_api } from '../../models/event_api.model';
import { GetEventsService } from '../../services/get-events.service';
import { Api } from '../../models/api.model';
import { HomeBannerComponent } from "../home-banner/home-banner.component";
import { Router } from '@angular/router';
import { HomePastEventComponent } from "../home-past-event/home-past-event.component";

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [
    HeaderComponent,
    FooterComponent,
    HomeBannerComponent,
    HomePastEventComponent
],
  templateUrl: './home.component.html',
  styleUrl: './home.component.scss'
})
export class HomeComponent implements OnInit{

  events: Event_api [] = [];
  future_events: Event_api[] = [];
  past_events: Event_api[] = [];
  accor_events: Event_api[] = [];

  constructor(
    private event_service: GetEventsService,
    private router: Router,
  ){ }

 ngOnInit(): void {
  this.event_service.getEvents().subscribe(
    (res: Api<Event_api>) => {
      this.accor_events = res['member'];
      console.log("Events", this.accor_events);
    },
    (error) => {
      console.error("Error fetching futur events", error);
    },
  );
 }

}
