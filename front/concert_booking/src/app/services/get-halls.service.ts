import { Injectable } from '@angular/core';
import { environment } from '../environment/environment';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Api } from '../models/api.model';
import { Hall } from '../models/hall.model';

@Injectable({
  providedIn: 'root'
})
export class GetHallsService {

  private API_URL = environment.apiUrl;

  constructor(private http: HttpClient) { }

  getHalls(): Observable<Api<Hall>>{

    return this.http.get<Api<Hall>>(this.API_URL + "/halls");

  }

  getHallById(id:number): Observable<Hall>{

    return this.http.get<Hall>(this.API_URL + "/halls/" + id);
  }
}
