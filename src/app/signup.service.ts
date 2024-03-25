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

  getCPUs() {
    return this.http.get<any[]>('http://localhost:8000/api/cpu');
  }

  getMotherboards() {
    return this.http.get<any[]>('http://localhost:8000/api/motherboard');
  }

  getMemory() {
    return this.http.get<any[]>('http://localhost:8000/api/memory');
  }

  getCoolers() {
    return this.http.get<any[]>('http://localhost:8000/api/cpu_cooler');
  }

  getPSUs() {
    return this.http.get<any[]>('http://localhost:8000/api/psu');
  }

  getGPUs() {
    return this.http.get<any[]>('http://localhost:8000/api/gpu');
  }

  getIHDs() {
    return this.http.get<any[]>('http://localhost:8000/api/internal_hard_drive');
  }

  getCases() {
    return this.http.get<any[]>('http://localhost:8000/api/pc_case');
  }
  
  saveConfiguration(configData: any) {
    return this.http.post<any>('http://localhost:8000/api/newconfig', configData);
  }

  getSavedConfigurations() {
    return this.http.get<any[]>('http://localhost:8000/api/configs');
  }
}
