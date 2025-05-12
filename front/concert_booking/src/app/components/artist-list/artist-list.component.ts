import { Component } from '@angular/core';
import { Artist } from '../../models/artist.model';
import { GetArtistsService } from '../../services/get-artists.service';
import { Router } from '@angular/router';
import { Api } from '../../models/api.model';
import { NgFor, NgIf, UpperCasePipe } from '@angular/common';
import { FormatCategoriesPipe } from '../../pipes/format-categories.pipe';
import { CardListComponent } from "../card-list/card-list.component";
import { HeaderComponent } from "../header/header.component";
import { FooterComponent } from "../footer/footer.component";

@Component({
  selector: 'app-artist-list',
  standalone: true,
  imports: [
    NgIf,
    CardListComponent,
    HeaderComponent,
    FooterComponent
],
  templateUrl: './artist-list.component.html',
  styleUrl: './artist-list.component.scss'
})
export class ArtistListComponent {

  artists: Artist[] = [];

  constructor(
    private artist_service: GetArtistsService,
    private router: Router,
  ){ }


  ngOnInit(): void {
    this.artist_service.getArtists().subscribe(
      (res: Api<Artist>) => {
        const allArtists = res['member'];
        this.artists = this.getRandomEvents(allArtists);
        console.log("artists", this.artists)
      },
      (error) => {
        console.error("Error fetching future events", error);
      }
    );
  }

  getRandomEvents(array: Artist[]): Artist[] {
    return [...array]
      .sort(() => 0.5 - Math.random())
  }

}
