import { Component, OnInit } from '@angular/core';
import { Artist } from '../../models/artist.model';
import { GetArtistsService } from '../../services/get-artists.service';
import { ActivatedRoute, Router } from '@angular/router';
import { Event_api } from '../../models/event_api.model';
import { NgFor, NgIf, UpperCasePipe } from '@angular/common';
import { CardListComponent } from '../card-list/card-list.component';
import { FormatCategoriesPipe } from '../../pipes/format-categories.pipe';
import { HeaderComponent } from "../header/header.component";
import { FooterComponent } from "../footer/footer.component";
import { GetEventsService } from '../../services/get-events.service';
import { Api } from '../../models/api.model';

@Component({
  selector: 'app-artist-detail',
  standalone: true,
  imports: [
    NgIf,
    CardListComponent,
    FormatCategoriesPipe,
    UpperCasePipe,
    HeaderComponent,
    FooterComponent
],
  templateUrl: './artist-detail.component.html',
  styleUrl: './artist-detail.component.scss'
})
export class ArtistDetailComponent implements OnInit{

  artist: Artist | undefined;
  events: Event_api[] = [];

  constructor(
    private artist_service: GetArtistsService,
    private event_service: GetEventsService,
    private router: Router,
    private actived_route: ActivatedRoute,
  ){ }

  ngOnInit(): void {
    const id = this.actived_route.snapshot.params["id"];

    this.artist_service.getArtistById(id).subscribe(
      (res: Artist) => {
        this.artist = res;
        console.log("fetching artist", this.artist);
        this.event_service.getArtistEvents(this.artist.id).subscribe(
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
        console.error("Error fetching artist", error);
      }
    );
  }

}
