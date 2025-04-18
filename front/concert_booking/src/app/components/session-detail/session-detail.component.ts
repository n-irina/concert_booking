import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { Session } from '../../models/session.model';
import { GetSessionsService } from '../../services/get-sessions.service';
import { Api } from '../../models/api.model';
import { DatePipe, NgClass, NgFor, NgIf, UpperCasePipe } from '@angular/common';
import { Event_api } from '../../models/event_api.model';
import { FormatCategoriesPipe } from '../../pipes/format-categories.pipe';
import { Category } from '../../models/category.model';
import { EventSharedService } from '../../services/event-shared.service';
import { FormatArtistsPipe } from '../../pipes/format-artists.pipe';
import { Hall } from '../../models/hall.model';

@Component({
  selector: 'app-session-detail',
  standalone: true,
  imports: [
    NgIf,
    NgFor,
    NgClass,
    DatePipe,
    FormatCategoriesPipe,
    UpperCasePipe,
    FormatArtistsPipe,
  ],
  templateUrl: './session-detail.component.html',
  styleUrl: './session-detail.component.scss'
})
export class SessionDetailComponent implements OnInit{

  session: Session[] | undefined;
  event: Event_api | undefined;
  hallName: string | null = null;
  categories: Category[] = [];
  minimum_price: number = 0;
  hall: Hall | undefined;
  showInfo: boolean = false;

  constructor(
    private session_service: GetSessionsService,
    private shared_service: EventSharedService,
    private activatedRoute: ActivatedRoute,
    private router: Router,
  ){ }

  ngOnInit(): void {

    this.hallName = this.activatedRoute.snapshot.queryParamMap.get("hall");
    const id: string | null = this.activatedRoute.snapshot.queryParamMap.get("eventId");

    if(this.hallName && id){
      this.session_service.getHallEventSessions(this.hallName, id).subscribe(
        (res: Api<Session>) => {
          this.session = res["member"];
          this.event = this.session[0].event;
          this.categories = this.shared_service.getCategories();
          this.minimum_price = this.getMinimumPrice(this.session);
          this.hall = this.session[0].hall;
          console.log("detail session",this.categories)
        },
        (error) => {
          console.error("Error fetching future events", error);
        }
      );
    }
  }

  getMinimumPrice(sessions: Session[]): number{
    let price: number = Infinity;
    for(const session of sessions){
      for(const seat of session.sessionSeatTypes){
        if(seat.price<price){
          price = seat.price;
        }
      }
    }
    return price;
  }

  showInformation(){
    this.showInfo = true;
  }

  closeInformation(){
    this.showInfo = false;
  }
}
