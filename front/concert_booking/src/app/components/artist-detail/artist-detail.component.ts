import { Component, OnInit } from '@angular/core';
import { Artist } from '../../models/artist.model';
import { GetArtistsService } from '../../services/get-artists.service';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-artist-detail',
  standalone: true,
  imports: [],
  templateUrl: './artist-detail.component.html',
  styleUrl: './artist-detail.component.scss'
})
export class ArtistDetailComponent implements OnInit{

  artist: Artist | undefined;

  constructor(
    private artist_service: GetArtistsService,
    private router: Router,
    private actived_route: ActivatedRoute,
  ){ }

  ngOnInit(): void {

    const id = this.actived_route.snapshot.params["id"];

    this.artist_service.getArtistById(id).subscribe(
      (res: Artist) => {
        this.artist = res;
        console.log("fetching artist", this.artist)
      },
      (error) => {
        console.error("Error fetching future events", error);
      }
    );
  }
}
