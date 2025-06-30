import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
import { throwError } from 'rxjs';
import { environment } from '../environment/environment';

export interface LoginCredentials {
  email: string;
  password: string;
}

@Injectable({ providedIn: 'root' })
export class AuthService {

  constructor(private http: HttpClient) {}

  private tokenKey = 'auth_token';
  private apiUrl = environment.apiUrl; // URL du backend Symfony

  isLoggedIn(): boolean {
    return !!localStorage.getItem(this.tokenKey);
  }

  getToken(): string | null {
    return localStorage.getItem(this.tokenKey);
  }

  login(credentials: LoginCredentials): Observable<any> {
    const headers = new HttpHeaders({
      'Content-Type': 'application/json'
    });

    console.log('Sending login request to:', `${this.apiUrl}/login`);
    console.log('Credentials:', credentials);
    console.log('Headers:', headers);

    return this.http.post(`${this.apiUrl}/login`, credentials, { headers })
      .pipe(
        map((response: any) => {
          console.log('Login response received:', response);
          if (response.token) {
            console.log('Token received:', response.token);
            localStorage.setItem(this.tokenKey, response.token);
            console.log('Token saved to localStorage');
          }
          return response;
        }),
        catchError((error: any) => {
          console.error('Login error details:', error);
          console.error('Error status:', error.status);
          console.error('Error message:', error.message);
          console.error('Error response:', error.error);
          return throwError(() => error);
        })
      );
  }

  logout(): void {
    localStorage.removeItem(this.tokenKey);
  }

  getLoginData(): Observable<any> {
    return this.http.get('./json/login.json')
      .pipe(
        map((result: any) => result),
        catchError((error: any) => {
          console.error('Erreur lors de la récupération des données de connexion:', error);
          return throwError(() => error);
        })
      );
  }
}
