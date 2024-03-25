// builder.component.ts

import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { AuthService } from '../auth.service';
import { SignupService } from '../signup.service';

@Component({
  selector: 'app-builder',
  templateUrl: './builder.component.html',
  styleUrls: ['./builder.component.css']
})
export class BuilderComponent implements OnInit {
  processors: any[] = [];
  motherboards: any[] = [];
  memories: any[] = [];
  processorCoolers: any[] = [];
  powerSupplies: any[] = [];
  graphicsCards: any[] = [];
  hardDrives: any[] = [];
  cases: any[] = [];
  selectedProcessor: number | null = null;
  selectedMotherboard: number | null = null;
  selectedMemory: number | null = null;
  selectedProcessorCooler: number | null = null;
  selectedPowerSupply: number | null = null;
  selectedGraphicsCard: number | null = null;
  selectedhardDrive: number | null = null;
  selectedCase: number | null = null;

  constructor(private http: HttpClient, private authService: AuthService, private signupService: SignupService, private router: Router) { }

  ngOnInit(): void {
    this.fetchProcessors();
    this.fetchMotherboards();
    this.fetchMemories();
    this.fetchProcessorCoolers();
    this.fetchPowerSupplies();
    this.fetchGraphicsCards();
    this.fetchHardDrives();
    this.fetchCases();
  }

  fetchProcessors(): void {
    this.http.get<any[]>('http://localhost:8000/api/cpu').subscribe(
      data => {
        this.processors = data; // Assuming data is an array of CPU options
      },
      error => {
        console.error('Error fetching CPU data:', error);
      }
    );
  }
  fetchMotherboards(): void {
    this.http.get<any[]>('http://localhost:8000/api/motherboard').subscribe(
      data => {
        this.motherboards = data; // Assuming data is an array of Motherboard options
      },
      error => {
        console.error('Error fetching MOBO data:', error);
      }
    );
  }
  fetchMemories(): void {
    this.http.get<any[]>('http://localhost:8000/api/memory').subscribe(
      data => {
        this.memories = data; // Assuming data is an array of Memory options
      },
      error => {
        console.error('Error fetching Memory data:', error);
      }
    );
  }
  fetchProcessorCoolers(): void {
    this.http.get<any[]>('http://localhost:8000/api/cpu_cooler').subscribe(
      data => {
        this.processorCoolers = data; // Assuming data is an array of CPU_Cooler options
      },
      error => {
        console.error('Error fetching CPU_Cooler data:', error);
      }
    );
  }
  fetchPowerSupplies(): void {
    this.http.get<any[]>('http://localhost:8000/api/psu').subscribe(
      data => {
        this.powerSupplies = data; // Assuming data is an array of PSU options
      },
      error => {
        console.error('Error fetching PSU data:', error);
      }
    );
  }
  fetchGraphicsCards(): void {
    this.http.get<any[]>('http://localhost:8000/api/gpu').subscribe(
      data => {
        this.graphicsCards = data; // Assuming data is an array of GPU options
      },
      error => {
        console.error('Error fetching GPU data:', error);
      }
    );
  }
  fetchHardDrives(): void {
    this.http.get<any[]>('http://localhost:8000/api/internal_hard_drive').subscribe(
      data => {
        this.hardDrives = data; // Assuming data is an array of IHD options
      },
      error => {
        console.error('Error fetching IHD data:', error);
      }
    );
  }
  fetchCases(): void {
    this.http.get<any[]>('http://localhost:8000/api/pc_case').subscribe(
      data => {
        this.cases = data; // Assuming data is an array of Case options
      },
      error => {
        console.error('Error fetching Case data:', error);
      }
    );
  }

  saveConfiguration(): void {
    // Check if the user is logged in
    const token = localStorage.getItem('token');
  if (token) {
    const headers = { 'Authorization': `Bearer ${token}` };
    // Make sure to replace the placeholders with the actual data from your dropdowns
    const configData = {
        cpu_id: this.selectedProcessor,
        motherboard_id: this.selectedMotherboard,
        memory_id: this.selectedMemory,
        cpu_cooler_id: this.selectedProcessorCooler,
        psu_id: this.selectedPowerSupply,
        gpu_id: this.selectedGraphicsCard,
        ihd_id: this.selectedhardDrive,
        case_id: this.selectedCase
        // Add other selected parts as needed
      };

      this.http.post('http://localhost:8000/api/newconfig', configData, { headers }).subscribe(
      response => {
        console.log('Configuration saved:', response);
        // Redirect or perform any other action upon successful save
      },
      error => {
        console.error('Error saving configuration:', error);
      }
    );
  } else {
    console.error('User not authenticated. Please log in.');
    // Redirect to login page or show an error message
  }
  }
}
