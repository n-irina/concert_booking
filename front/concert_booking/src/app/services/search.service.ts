import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { map } from 'rxjs/operators';

@Injectable({
  providedIn: 'root'
})
export class SearchService {

  constructor(private http: HttpClient) { }

  search(query: string) {
    return this.http.get<any>('https://localhost:8000/api/search?q=' + query).pipe(
      map(res => [
        ...res.events.map((e: any) => ({ id: e.id, label: e.name, type: 'event' })),
        ...res.artists.map((a: any) => ({ id: a.id, label: a.nickname, type: 'artist' })),
        ...res.categories.map((c: any) => ({ id: c.id, label: c.name, type: 'category' })),
        ...res.halls.map((h: any) => ({ id: h.id, label: h.name, type: 'hall'})),
      ])
    );
  }
}
