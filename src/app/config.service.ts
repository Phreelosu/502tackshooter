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
    // Get the authentication token from local storage
    const token = localStorage.getItem('token');
    // If the token exists, include it in the request headers
    if (token) {
      const headers = new HttpHeaders({
        'Authorization': `Bearer ${token}`
      });
      // Make the HTTP request with the headers
      return this.http.get<Config[]>('http://localhost:8000/api/configs', { headers });
    } else {
      // Handle case where user is not authenticated
      // For now, returning an empty observable, but you can handle this according to your application logic
      return new Observable<Config[]>(observer => {
        observer.error('User not authenticated');
        observer.complete();
      });
    }
  }
  deleteConfig(configId: number): Observable<void> {
    // Get the authentication token from local storage
    const token = localStorage.getItem('token');
    // If the token exists, include it in the request headers
    if (token) {
      const headers = new HttpHeaders({
        'Authorization': `Bearer ${token}`
      });
      // Construct the URL for deleting a config
      const url = `http://localhost:8000/api/deleteconfig`;
      // Prepare the request body
      const requestBody = { config_id: configId };
      // Make the HTTP DELETE request to delete the config with the headers
      return this.http.delete<void>(url, { headers, body: requestBody });
    } else {
      // Handle case where user is not authenticated
      // For now, returning an empty observable, but you can handle this according to your application logic
      return new Observable<void>(observer => {
        observer.error('User not authenticated');
        observer.complete();
      });
    }
  }


}