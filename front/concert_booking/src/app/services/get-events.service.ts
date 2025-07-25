import { Injectable } from '@angular/core';
import { environment } from '../environment/environment';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Api } from '../models/api.model';
import { Event_api } from '../models/event_api.model';
import { Hall } from '../models/hall.model';

@Injectable({
  providedIn: 'root'
})
export class GetEventsService {

  private API_URL = environment.apiUrl;

  constructor(private http: HttpClient) { }

  getEvents(): Observable<Api<Event_api>>{

    return this.http.get<Api<Event_api>>(this.API_URL + "/events");

  }

  getFutureEvents(): Observable<Api<Event_api>>{

    return this.http.get<Api<Event_api>>(this.API_URL + "/events?future=true");

  }

  getPastEvents(): Observable<Api<Event_api>>{

    return this.http.get<Api<Event_api>>(this.API_URL + "/events?future=false");

  }

  getHallEvents(hall: Hall): Observable<Api<Event_api>> {
    const url = `${this.API_URL}/events?hall=${encodeURIComponent(hall.name)}&future=true`;
    console.log("Requesting hall events from:", url);
    return this.http.get<Api<Event_api>>(url);
  }

  getArtistEvents(id: number): Observable<Api<Event_api>>{

    return this.http.get<Api<Event_api>>(this.API_URL + "/events?artist=" + id);

  }

  getEventById(id: number): Observable<Event_api>{

    return this.http.get<Event_api>(this.API_URL + "/events/" + id);

  }
}
