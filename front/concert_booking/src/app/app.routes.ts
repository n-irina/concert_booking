import { Routes } from '@angular/router';
import { HomeComponent } from './components/home/home.component';
import { ConcertDetailComponent } from './components/concert-detail/concert-detail.component';
import { ConcertListComponent } from './components/concert-list/concert-list.component';

export const routes: Routes = [

  { path: "", component: HomeComponent},
  { path: "concert", component: ConcertListComponent},
  { path: "concert/:id", component: ConcertDetailComponent}

];
