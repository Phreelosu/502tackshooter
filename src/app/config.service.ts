import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Config } from './config.model';

@Injectable({
  providedIn: 'root'
})
export class ConfigService {
  getPartName(partType: string, id: number): Observable<string> {
    // Construct the URL based on the partType and id
    const url = `http://localhost:8000/api/${partType}/${id}`;
    // Make the HTTP GET request to fetch the part name
    return this.http.get<string>(url);
  }

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
}