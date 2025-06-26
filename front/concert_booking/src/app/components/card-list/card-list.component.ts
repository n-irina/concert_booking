import { NgFor, NgIf, UpperCasePipe } from '@angular/common';
import { Component, Input } from '@angular/core';
import { Router, RouterModule } from '@angular/router';
import { FormatArtistsPipe } from '../../pipes/format-artists.pipe';
import { FormatCategoriesPipe } from '../../pipes/format-categories.pipe';
import { Event_api } from '../../models/event_api.model';
import { Category } from '../../models/category.model';
import { Session } from '../../models/session.model';

@Component({
  selector: 'app-card-list',
  standalone: true,
  imports: [
    NgFor,
    NgIf,
    FormatArtistsPipe,
    FormatCategoriesPipe,
    UpperCasePipe,
    RouterModule,
  ],
  templateUrl: './card-list.component.html',
  styleUrl: './card-list.component.scss'
})
export class CardListComponent {

  @Input() items: any[] = [];
  @Input() type: 'artist' | 'event' | 'hall'= 'artist';
  @Input() sessions?: Session[];
  @Input() hallId?: number;

  constructor(private router: Router) {}

  goToDetails(id: number) {
    if (this.type === 'artist') {
      this.router.navigate(['/artist', id]);
    } else if (this.type === 'event') {
      this.router.navigate(['/events', id, 'sessions']);
    }
    else {
      this.router.navigate(['/hall', id]);
    }
  }

  getAllCategoriesFromEvent(item: Event_api): Category[] {
    return Array.isArray(item?.artist)
      ? item.artist.flatMap(a => Array.isArray(a.category) ? a.category : [])
      : [];
  }

}
