import { Component } from '@angular/core';
import { Hall } from '../../models/hall.model';
import { GetHallsService } from '../../services/get-halls.service';
import { Router } from '@angular/router';
import { Api } from '../../models/api.model';
import { NgIf } from '@angular/common';
import { CardListComponent } from "../card-list/card-list.component";
import { HeaderComponent } from "../header/header.component";
import { FooterComponent } from "../footer/footer.component";

@Component({
  selector: 'app-hall-list',
  standalone: true,
  imports: [
    NgIf,
    CardListComponent,
    HeaderComponent,
    FooterComponent
],
  templateUrl: './hall-list.component.html',
  styleUrl: './hall-list.component.scss'
})
export class HallListComponent {

  halls: Hall[] = [];

  constructor(
    private hall_service: GetHallsService,
    private router: Router,
  ){ }


  ngOnInit(): void {
    this.hall_service.getHalls().subscribe(
      (res: Api<Hall>) => {
        this.halls = res['member'];
        console.log("halls", this.halls)
      },
      (error) => {
        console.error("Error fetching future events", error);
      }
    );
  }

}
