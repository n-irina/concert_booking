import { Routes } from '@angular/router';
import { HomeComponent } from './components/home/home.component';
import { ConcertDetailComponent } from './components/concert-detail/concert-detail.component';
import { ConcertListComponent } from './components/concert-list/concert-list.component';
import { SessionDetailComponent } from './components/session-detail/session-detail.component';
import { ArtistListComponent } from './components/artist-list/artist-list.component';
import { ArtistDetailComponent } from './components/artist-detail/artist-detail.component';
import { HallListComponent } from './components/hall-list/hall-list.component';
import { HallDetailComponent } from './components/hall-detail/hall-detail.component';
import { CategoryListComponent } from './components/category-list/category-list.component';
import { CategoryDetailComponent } from './components/category-detail/category-detail.component';
import { LandingPageComponent } from './components/landing-page/landing-page.component';
import { SubscriptionFormComponent } from './components/subscription-form/subscription-form.component';
import { LoginComponent } from './components/login/login.component';
import { authGuard } from './guards/auth.guard';

export const routes: Routes = [

  { path: "", component: HomeComponent },
  { path: "concert", component: ConcertListComponent },
  { path: "concert/:id", component: ConcertDetailComponent },
  { path: "concert/:id/reserve/:hall", component: ConcertDetailComponent, canActivate: [authGuard] },
  { path: "session", component: SessionDetailComponent },
  { path: "session/:sessionId", component: SessionDetailComponent },
  { path: "artist", component: ArtistListComponent },
  { path: "artist/:id", component: ArtistDetailComponent },
  { path: "hall", component: HallListComponent },
  { path: "hall/:id", component: HallDetailComponent },
  { path: "category", component: CategoryListComponent },
  { path: "category/:id", component: CategoryDetailComponent },
  { path: "category/artist/:id", component: ArtistListComponent },
  { path: "category/hall/:id", component: HallListComponent },
  { path: "category/concert/:id", component: ConcertListComponent },
  { path: "subscription-form", component: SubscriptionFormComponent },
  { path: "login", component: LoginComponent },
  { path: "connexion", component: LoginComponent },
  { path: "events/:eventId/sessions", component: SessionDetailComponent, canActivate: [authGuard] },
  { path: "hall/:hallId/event/:eventId/sessions", component: SessionDetailComponent, canActivate: [authGuard] },

];
