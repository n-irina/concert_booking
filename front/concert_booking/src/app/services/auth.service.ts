import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable, throwError } from 'rxjs';
import { map, catchError } from 'rxjs/operators';
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

    return this.http.post(`${this.apiUrl}/login`, credentials, { headers })
      .pipe(
        map((response: any) => {
          if (response.token) {
            localStorage.setItem(this.tokenKey, response.token);
          }
          return response;
        }),
        catchError((error: any) => {
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
          return throwError(() => error);
        })
      );
  }
}
