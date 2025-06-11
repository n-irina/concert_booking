import { Component, OnInit } from '@angular/core';
import { Category } from '../../models/category.model';
import { ActivatedRoute } from '@angular/router';
import { GetCategoriesService } from '../../services/get-categories.service';
import { NgFor, NgIf } from '@angular/common';
import { CardListComponent } from '../card-list/card-list.component';
import { Artist } from '../../models/artist.model';
import { Event_api } from '../../models/event_api.model';
import { GetEventsService } from '../../services/get-events.service';
import { FooterComponent } from '../footer/footer.component';
import { HeaderComponent } from '../header/header.component';

@Component({
  selector: 'app-category-detail',
  standalone: true,
  imports: [
    NgIf,
    NgFor,
    CardListComponent,
    HeaderComponent,
    FooterComponent
  ],
  templateUrl: './category-detail.component.html',
  styleUrl: './category-detail.component.scss'
})
export class CategoryDetailComponent implements OnInit {

  categoryId: number = 0;
  category: Category | undefined;
  artists: Artist[] = [];
  eventsByArtist: { artistId: number, events: Event_api[] }[] = [];

  constructor(private route: ActivatedRoute, private categoryService: GetCategoriesService, private eventsService: GetEventsService) { }

  ngOnInit(): void {
    this.route.params.subscribe(res => {
      this.categoryId = res['id'];
      this.categoryService.getCategoryById(this.categoryId).subscribe(category => {
        this.category = category;
        this.artists = category.artists;
        this.artists.forEach(artist => {
          this.eventsService.getArtistEvents(artist.id).subscribe(res => {
            const events = res["member"] || [];
            this.eventsByArtist.push({artistId: artist.id, events: events});
            console.log('Events updated for artist', artist.id, this.eventsByArtist);
          });
        });
      });
    });
  }

  getArtistEvents(artistId: number): Event_api[] {
    const artistEvents = this.eventsByArtist.find(item => item.artistId === artistId);
    return artistEvents ? artistEvents.events : [];
  }

  hasEvents(artistId: number): boolean {
    const artistEvents = this.getArtistEvents(artistId);
    return Array.isArray(artistEvents) && artistEvents.length > 0;
  }

  prepareEventsForCardList(artistId: number): Event_api[] {
    const events = this.getArtistEvents(artistId);
    // Ne pas ajouter de tableau events vide, car nous ne sommes pas dans le cas d'un artiste
    return events;
  }
}
