import { Injectable } from '@angular/core';
import { environment } from '../environment/environment';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Category } from '../models/category.model';
import { Api } from '../models/api.model';


@Injectable({
  providedIn: 'root'
})
export class GetCategoriesService {

  private API_URL = environment.apiUrl;

  constructor(private http: HttpClient) { }

  getCategories(): Observable<Api<Category>> {
    return this.http.get<Api<Category>>(`${this.API_URL}/categories`);
  }

  getCategoryById(id: number): Observable<Category> {
    return this.http.get<Category>(`${this.API_URL}/categories/${id}`);
  }
}
