import { Component, OnInit } from '@angular/core';
import { HeaderComponent } from '../header/header.component';
import { FooterComponent } from '../footer/footer.component';
import { Event_api } from '../../models/event_api.model';
import { GetEventsService } from '../../services/get-events.service';
import { Api } from '../../models/api.model';
import { Hall } from '../../models/hall.model';
import { HomeBannerComponent } from "../home-banner/home-banner.component";

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [
    HeaderComponent,
    FooterComponent,
    HomeBannerComponent
],
  templateUrl: './home.component.html',
  styleUrl: './home.component.scss'
})
export class HomeComponent implements OnInit{

  events: Event_api [] = [];
  future_events: Event_api[] = [];
  past_events: Event_api[] = [];
  accor_events: Event_api[] = [];
  hall: Hall = {
     "@id": "/api/halls/153",
      "@type": "Hall",
      "id": 153,
      "name": "Accor Arena Bercy",
      "address": "8 boulevard de Bercy 75012 Paris",
      "capacity": 20000,
      "description": "A pyramid of grass planted at the western end of the park, on the banks of the Seine, the spot hosts international gymnastics competitions as well as boxing matches, but above all a plethora of French and international artists.",
      "sessions": [
        "/api/sessions/172",
        "/api/sessions/173",
        "/api/sessions/174",
        "/api/sessions/175",
        "/api/sessions/183",
        "/api/sessions/184",
        "/api/sessions/187"
      ],
      "hallSeatTypes": [
        "/api/hall_seat_types/98",
        "/api/hall_seat_types/99",
        "/api/hall_seat_types/100",
        "/api/hall_seat_types/101",
        "/api/hall_seat_types/102"
      ],
      "picture_path": "accor_arena.jpg"
    };

  constructor(
    private event_service: GetEventsService,
  ){ }

 ngOnInit(): void {
  this.event_service.getHallEvents(this.hall).subscribe(
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
