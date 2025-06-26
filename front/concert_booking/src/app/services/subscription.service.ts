import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from '../environment/environment';
import { Observable } from 'rxjs';
import { PostUser } from '../models/post_user.model';
import { User } from '../models/user.model';

@Injectable({
  providedIn: 'root'
})
export class SubscriptionService {
  private readonly API_URL = environment.apiUrl;

  constructor(private http: HttpClient) { }

  // Store email temporarily
  private tempEmail: string | null = null;

  setTempEmail(email: string) {
    this.tempEmail = email;
  }

  getTempEmail(): string | null {
    return this.tempEmail;
  }

  clearTempEmail() {
    this.tempEmail = null;
  }

  // API call to create new user
  createUser(userData: PostUser): Observable<User> {
    const headers = new HttpHeaders()
      .set('Content-Type', 'application/ld+json')
      .set('Accept', 'application/ld+json');

    // Format the data for API Platform
    const apiData = {
      "@context": "/api/contexts/User",
      "@type": "User",
      "email": userData.email,
      "plain_password": userData.plain_password
    };

    console.log('API URL:', `${this.API_URL}/users`);
    console.log('Headers:', headers);
    console.log('Creating user with data:', apiData);

    return this.http.post<User>(`${this.API_URL}/users`, apiData, { headers });
  }
}
