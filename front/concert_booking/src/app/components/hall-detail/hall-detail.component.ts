import { Component } from '@angular/core';
import { Hall } from '../../models/hall.model';
import { Event_api } from '../../models/event_api.model';
import { GetHallsService } from '../../services/get-halls.service';
import { GetEventsService } from '../../services/get-events.service';
import { ActivatedRoute, Router } from '@angular/router';
import { Api } from '../../models/api.model';
import { NgIf } from '@angular/common';
import { CardListComponent } from "../card-list/card-list.component";
import { HeaderComponent } from "../header/header.component";
import { FooterComponent } from "../footer/footer.component";

@Component({
  selector: 'app-hall-detail',
  standalone: true,
  imports: [
    NgIf,
    CardListComponent,
    HeaderComponent,
    FooterComponent
],
  templateUrl: './hall-detail.component.html',
  styleUrl: './hall-detail.component.scss'
})
export class HallDetailComponent {


  hall: Hall | undefined;
  events: Event_api[] = [];

  constructor(
    private hall_service: GetHallsService,
    private event_service: GetEventsService,
    private router: Router,
    private actived_route: ActivatedRoute,
  ){ }

  ngOnInit(): void {
    const id = this.actived_route.snapshot.params["id"];

    this.hall_service.getHallById(id).subscribe(
      (res: Hall) => {
        this.hall = res;
        console.log("fetching hall", this.hall);

        this.event_service.getHallEvents(this.hall).subscribe(
          (res: Api<Event_api>) => {
            this.events = res["member"];
            console.log("fetching event", this.events);
          },
          (error) => {
            console.error("Error fetching event", error);
          }
        );
      },
      (error) => {
        console.error("Error fetching hall", error);
      }
    );
  }

}

