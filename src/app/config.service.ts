import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Config } from './config.model';

@Injectable({
  providedIn: 'root'
})
export class ConfigService {
  constructor(private http: HttpClient) { }

  getUserConfigs(): Observable<Config[]> {
    const token = localStorage.getItem('token');
    if (token) {
      const headers = new HttpHeaders({
        'Authorization': `Bearer ${token}`
      });
      return this.http.get<Config[]>('http://localhost:8000/api/configs', { headers });
    } else {
      return new Observable<Config[]>(observer => {
        observer.error('User not authenticated');
        observer.complete();
      });
    }
  }
  deleteConfig(configId: number): Observable<void> {
    const token = localStorage.getItem('token');
    if (token) {
      const headers = new HttpHeaders({
        'Authorization': `Bearer ${token}`
      });
      const url = `http://localhost:8000/api/deleteconfig`;
      const requestBody = { config_id: configId };
      return this.http.delete<void>(url, { headers, body: requestBody });
    } else {
      return new Observable<void>(observer => {
        observer.error('User not authenticated');
        observer.complete();
      });
    }
  }
}