import { NgFor, NgIf, UpperCasePipe } from '@angular/common';
import { Component, Input } from '@angular/core';
import { Router } from '@angular/router';
import { FormatArtistsPipe } from '../../pipes/format-artists.pipe';
import { FormatCategoriesPipe } from '../../pipes/format-categories.pipe';

@Component({
  selector: 'app-card-list',
  standalone: true,
  imports: [
    NgFor,
    NgIf,
    FormatArtistsPipe,
    FormatCategoriesPipe,
    UpperCasePipe,
  ],
  templateUrl: './card-list.component.html',
  styleUrl: './card-list.component.scss'
})
export class CardListComponent {

  @Input() items: any[] = [];
  @Input() type: 'artist' | 'event' = 'artist';

  constructor(private router: Router) {}

  goToDetails(id: number) {
    if (this.type === 'artist') {
      this.router.navigate(['/artist', id]);
    } else {
      this.router.navigate(['/concert', id]);
    }
  }

  getUniqueCategoriesFromEvent(item: any): any[] {
    if (!item?.artist) return [];
    const allCategories = item.artist.flatMap((a: any) => a.category);
    const map = new Map<number, any>();
    allCategories.forEach((c: any) => map.set(c.id, c));
    return Array.from(map.values());
  }
}
