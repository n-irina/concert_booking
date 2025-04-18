import { Injectable } from '@angular/core';
import { environment } from '../environment/environment';
import { HttpClient } from '@angular/common/http';
import { Hall } from '../models/hall.model';
import { Observable } from 'rxjs';
import { Api } from '../models/api.model';
import { Session } from '../models/session.model';

@Injectable({
  providedIn: 'root'
})
export class GetSessionsService {

  private API_URL = environment.apiUrl;

  constructor(private http: HttpClient) { }

  getHallEventSessions(hallName: string, eventId: string): Observable<Api<Session>>{

    return this.http.get<Api<Session>>(this.API_URL + "/sessions?hall=" + hallName + "&event=" +eventId);

  }

}
