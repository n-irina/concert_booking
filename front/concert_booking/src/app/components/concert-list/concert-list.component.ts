import { Component } from '@angular/core';
import { Event_api } from '../../models/event_api.model';
import { GetEventsService } from '../../services/get-events.service';
import { Router } from '@angular/router';
import { Api } from '../../models/api.model';
import { NgFor, NgIf, UpperCasePipe } from '@angular/common';
import { Category } from '../../models/category.model';
import { EventSharedService } from '../../services/event-shared.service';
import { FormatCategoriesPipe } from '../../pipes/format-categories.pipe';
import { FormatArtistsPipe } from '../../pipes/format-artists.pipe';

@Component({
  selector: 'app-concert-list',
  standalone: true,
  imports: [
    NgIf,
    NgFor,
    FormatCategoriesPipe,
    FormatArtistsPipe,
    UpperCasePipe,
  ],
  templateUrl: './concert-list.component.html',
  styleUrl: './concert-list.component.scss'
})
export class ConcertListComponent {

  future_events: Event_api[] = [];

  constructor(
    private event_service: GetEventsService,
    private shared_service: EventSharedService,
    private router: Router,
  ){ }


  ngOnInit(): void {
    this.event_service.getFutureEvents().subscribe(
      (res: Api<Event_api>) => {
        const allEvents = res['member'];
        this.future_events = this.getRandomEvents(allEvents);
      },
      (error) => {
        console.error("Error fetching future events", error);
      }
    );
  }

  getRandomEvents(array: Event_api[]): Event_api[] {
    return [...array]
      .sort(() => 0.5 - Math.random())
  }

  goToDetails(id: number): void{
    this.router.navigate(["/concert/" + id]);
  }

  getUniqueCategories(event: Event_api): Category[] {
    const allCategories = event.artist.flatMap(a => a.category);
    const unique = new Map<number, Category>();
    for (const c of allCategories) {
      unique.set(c.id, c);
    }
    return Array.from(unique.values());
  }
}
