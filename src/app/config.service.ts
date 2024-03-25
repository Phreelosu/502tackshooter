import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Config } from './config.model';

@Injectable({
  providedIn: 'root'
})
export class ConfigService {

  constructor(private http: HttpClient) { }

  getUserConfigs(): Observable<Config[]> {
    return this.http.get<Config[]>('http://localhost:8000/api/configs');
  }
}