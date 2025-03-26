import { Component, OnInit } from '@angular/core';
import { Event_api } from '../../models/event_api.model';
import { GetEventsService } from '../../services/get-events.service';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-concert-detail',
  standalone: true,
  imports: [],
  templateUrl: './concert-detail.component.html',
  styleUrl: './concert-detail.component.scss'
})
export class ConcertDetailComponent implements OnInit{

  event: Event_api | undefined;

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
        console.log("detail event", this.event)
      },
      (error) => {
        console.error("Error fetching future events", error);
      }
    );


  }

}
