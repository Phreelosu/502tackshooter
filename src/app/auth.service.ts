import { Injectable, EventEmitter } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  loginSuccessEvent: EventEmitter<string> = new EventEmitter<string>();
  signupSuccessEvent: EventEmitter<string> = new EventEmitter<string>();
  loginStatusChange: EventEmitter<boolean> = new EventEmitter<boolean>(); // Add login status change event

  constructor(private http: HttpClient) {}

  login(username: string, password: string): Observable<any> {
    return this.http.post<any>('http://localhost:8000/api/login', { username, password });
  }

  logout(): void {
    localStorage.removeItem('token');
    this.loginStatusChange.emit(false); // Emit false when logging out
  }

  getToken(): string | null {
    return localStorage.getItem('token');
  }

  isLoggedIn(): boolean {
    return this.getToken() !== null;
  }

  emitLoginSuccessMessage(message: string): void {
    this.loginSuccessEvent.emit(message);
  }

  emitLoginStatusChange(status: boolean): void {
    this.loginStatusChange.emit(status);
  }

  emitSignupSuccessMessage(message: string): void { // Method to emit signup success event
    this.signupSuccessEvent.emit(message);
  }
}
