import { Component, OnInit } from '@angular/core';
import { Event_api } from '../../models/event_api.model';
import { GetEventsService } from '../../services/get-events.service';
import { Api } from '../../models/api.model';
import { NgFor, NgIf } from '@angular/common';
import { FormatArtistsPipe } from '../../pipes/format-artists.pipe';
import { Router } from '@angular/router';

@Component({
  selector: 'app-home-past-event',
  standalone: true,
  imports: [
    NgIf,
    FormatArtistsPipe,
    NgFor,
  ],
  templateUrl: './home-past-event.component.html',
  styleUrl: './home-past-event.component.scss'
})
export class HomePastEventComponent implements OnInit{

  past_event: Event_api[] = [];

  constructor(
    private service: GetEventsService,
    private router: Router
  ){ }

  ngOnInit(): void {

    this.service.getPastEvents().subscribe(
      (res: Api<Event_api>) => {
        this.past_event = res["member"];
        console.log("past event", this.past_event)
      },
      (error) => {
        console.error("Error fetching future events", error);
      }
    );
  }

  goToConcertDetail(id: number): void {
    this.router.navigate(['/concert/'+ id]);
  }
}
