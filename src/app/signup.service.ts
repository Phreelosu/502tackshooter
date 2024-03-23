import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class SignupService {

  constructor(private http: HttpClient) { }

  signUp(data: any) {
    return this.http.post<any>('http://localhost:8000/api/register', data);
  }

  logIn(data: any){
    return this.http.post<any>('http://localhost:8000/api/login', data);
  }
}