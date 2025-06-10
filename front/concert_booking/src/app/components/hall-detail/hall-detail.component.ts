import { Component } from '@angular/core';
import { Hall } from '../../models/hall.model';
import { Event_api } from '../../models/event_api.model';
import { GetHallsService } from '../../services/get-halls.service';
import { GetEventsService } from '../../services/get-events.service';
import { GetSessionsService } from '../../services/get-sessions.service';
import { ActivatedRoute, Router } from '@angular/router';
import { Api } from '../../models/api.model';
import { NgIf } from '@angular/common';
import { CardListComponent } from "../card-list/card-list.component";
import { HeaderComponent } from "../header/header.component";
import { FooterComponent } from "../footer/footer.component";
import { Session } from '../../models/session.model';
import { forkJoin } from 'rxjs';
import { map, switchMap } from 'rxjs/operators';

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
  sessions: Session[] = [];
  filteredEvents: Event_api[] = [];

  constructor(
    private hall_service: GetHallsService,
    private event_service: GetEventsService,
    private session_service: GetSessionsService,
    private router: Router,
    private actived_route: ActivatedRoute,
  ){ }

  ngOnInit(): void {
    const id = this.actived_route.snapshot.params["id"];

    this.hall_service.getHallById(id).subscribe(
      (res: Hall) => {
        this.hall = res;
        console.log("Hall récupéré:", this.hall);

        // Récupérer les événements et leurs sessions
        this.event_service.getHallEvents(this.hall).pipe(
          switchMap((eventRes: Api<Event_api>) => {
            this.events = eventRes["member"];
            console.log("Événements récupérés:", this.events);

            if (this.events.length === 0) {
              console.log("Aucun événement trouvé pour ce hall");
              return [];
            }

            // Pour chaque événement, récupérer ses sessions dans ce hall
            const sessionRequests = this.events.map(event => {
              console.log(`Récupération des sessions pour l'événement ${event.id}`);
              return this.session_service.getHallEventSessions(this.hall!.id.toString(), event.id.toString());
            });

            return forkJoin(sessionRequests);
          })
        ).subscribe(
          (sessionResults) => {
            if (!Array.isArray(sessionResults)) {
              console.log("Pas de résultats de sessions");
              return;
            }

            // Combiner toutes les sessions
            this.sessions = sessionResults.flatMap(res => {
              console.log("Résultat de session:", res);
              return res["member"] || [];
            });
            console.log("Toutes les sessions:", this.sessions);

            // Filtrer les événements qui ont des sessions
            const eventIdsWithSessions = new Set(this.sessions.map(session => session.event.id));
            console.log("IDs des événements avec sessions:", Array.from(eventIdsWithSessions));

            this.filteredEvents = this.events.filter(event => eventIdsWithSessions.has(event.id));
            console.log("Événements filtrés final:", this.filteredEvents);
          },
          (error) => {
            console.error("Error fetching sessions", error);
          }
        );
      },
      (error) => {
        console.error("Error fetching hall", error);
      }
    );
  }
}

