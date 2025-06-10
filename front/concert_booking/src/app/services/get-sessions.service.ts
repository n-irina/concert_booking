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

  getHallEventSessions(hallId: string, eventId: string): Observable<Api<Session>> {
    const url = `${this.API_URL}/sessions?event=${eventId}`;
    console.log("Requesting sessions from:", url);
    return this.http.get<Api<Session>>(url);
  }

  getSessionById(sessionId: string): Observable<Session> {
    const url = `${this.API_URL}/sessions/${sessionId}`;
    console.log("Requesting session by ID from:", url);
    return this.http.get<Session>(url);
  }
}
