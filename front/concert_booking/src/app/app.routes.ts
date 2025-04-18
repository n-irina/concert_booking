import { Routes } from '@angular/router';
import { HomeComponent } from './components/home/home.component';
import { ConcertDetailComponent } from './components/concert-detail/concert-detail.component';
import { ConcertListComponent } from './components/concert-list/concert-list.component';
import { SessionDetailComponent } from './components/session-detail/session-detail.component';
import { ArtistListComponent } from './components/artist-list/artist-list.component';
import { ArtistDetailComponent } from './components/artist-detail/artist-detail.component';

export const routes: Routes = [

  { path: "", component: HomeComponent },
  { path: "concert", component: ConcertListComponent },
  { path: "concert/:id", component: ConcertDetailComponent },
  { path: "session", component: SessionDetailComponent },
  { path: "artist", component: ArtistListComponent },
  { path: "artist/:id", component: ArtistDetailComponent },

];
