import { Injectable } from '@angular/core';
import { environment } from '../environment/environment';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Api } from '../models/api.model';
import { Artist } from '../models/artist.model';

@Injectable({
  providedIn: 'root'
})
export class GetArtistsService {

  private API_URL = environment.apiUrl;

  constructor(private http: HttpClient) { }

  getArtists(): Observable<Api<Artist>>{

    return this.http.get<Api<Artist>>(this.API_URL + "/artists");

  }
}
