import { Injectable } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Config } from './config.model';

@Injectable({
  providedIn: 'root'
})
export class ConfigService {
  getPartName(id: any): any {
    throw new Error('Method not implemented.');
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
  getCaseName(id: number): Observable<string[]> {
    return this.http.get<string[]>(`http://localhost:8000/api/pc_case/${id}`);
  }
  getCPUName(id: number): Observable<string[]> {
    return this.http.get<string[]>(`http://localhost:8000/api/cpu/${id}`);
  }
  getCPUCoolerName(id: number): Observable<string[]> {
    return this.http.get<string[]>(`http://localhost:8000/api/cpu_cooler/${id}`);
  }
  getGPUName(id: number): Observable<string[]> {
    return this.http.get<string[]>(`http://localhost:8000/api/gpu/${id}`);
  }
  getIHDName(id: number): Observable<string[]> {
    return this.http.get<string[]>(`http://localhost:8000/api/internal_hard_drive/${id}`);
  }
  getMemoryName(id: number): Observable<string[]> {
    return this.http.get<string[]>(`http://localhost:8000/api/memory/${id}`);
  }
  getMotherboardName(id: number): Observable<string[]> {
    return this.http.get<string[]>(`http://localhost:8000/api/motherboard/${id}`);
  }
  getPowerSupplyName(id: number): Observable<string[]> {
    return this.http.get<string[]>(`http://localhost:8000/api/psu/${id}`);
  }

}