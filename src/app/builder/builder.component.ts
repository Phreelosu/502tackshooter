import { Component, OnInit } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { ActivatedRoute, Router } from '@angular/router';
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
  mode!: 'create' | 'modify';
  configId: number | null = null; 

  constructor(
    private http: HttpClient, 
    private authService: AuthService, 
    private router: Router,
    private route: ActivatedRoute 
  ) { }
  
  ngOnInit(): void {
    this.mode = 'create';
    this.fetchProcessors();
    this.fetchMotherboards();
    this.fetchMemories();
    this.fetchProcessorCoolers();
    this.fetchPowerSupplies();
    this.fetchGraphicsCards();
    this.fetchHardDrives();
    this.fetchCases();
  
    this.route.params.subscribe(params => {
      if (params['id']) {
        this.mode = 'modify';
        this.configId = params['id'];
        this.fetchConfig(params['id']);
      }
    });
  }
  

  isLoggedIn(): boolean {
    return localStorage.getItem('token') !== null;
  }

  redirectToLogin(): void {
    this.router.navigate(['/login']);
  }

  fetchProcessors(): void {
    this.http.get<any[]>('http://localhost:8000/api/cpu').subscribe(
      data => {
        console.log('Fetched processors:', data);
        this.processors = data;
      },
      error => {
        console.error('Error fetching CPU data:', error);
      }
    );
  }
  
  fetchMotherboards(): void {
    this.http.get<any[]>('http://localhost:8000/api/motherboard').subscribe(
      data => {
        this.motherboards = data;
      },
      error => {
        console.error('Error fetching MOBO data:', error);
      }
    );
  }
  fetchMemories(): void {
    this.http.get<any[]>('http://localhost:8000/api/memory').subscribe(
      data => {
        this.memories = data;
      },
      error => {
        console.error('Error fetching Memory data:', error);
      }
    );
  }
  fetchProcessorCoolers(): void {
    this.http.get<any[]>('http://localhost:8000/api/cpu_cooler').subscribe(
      data => {
        this.processorCoolers = data;
      },
      error => {
        console.error('Error fetching CPU_Cooler data:', error);
      }
    );
  }
  fetchPowerSupplies(): void {
    this.http.get<any[]>('http://localhost:8000/api/psu').subscribe(
      data => {
        this.powerSupplies = data;
      },
      error => {
        console.error('Error fetching PSU data:', error);
      }
    );
  }
  fetchGraphicsCards(): void {
    this.http.get<any[]>('http://localhost:8000/api/gpu').subscribe(
      data => {
        this.graphicsCards = data;
      },
      error => {
        console.error('Error fetching GPU data:', error);
      }
    );
  }
  fetchHardDrives(): void {
    this.http.get<any[]>('http://localhost:8000/api/internal_hard_drive').subscribe(
      data => {
        this.hardDrives = data;
      },
      error => {
        console.error('Error fetching IHD data:', error);
      }
    );
  }
  fetchCases(): void {
    this.http.get<any[]>('http://localhost:8000/api/pc_case').subscribe(
      data => {
      },
      error => {
        console.error('Error fetching Case data:', error);
      }
    );
  }

  saveConfiguration(): void {
    const token = localStorage.getItem('token');
    if (!token) {
      console.error('User not authenticated. Redirecting to login page.');
      return;
    }
  
    const headers = { 'Authorization': `Bearer ${token}` };
    const configData = {
      cpu_id: this.selectedProcessor,
      motherboard_id: this.selectedMotherboard,
      memory_id: this.selectedMemory,
      cpu_cooler_id: this.selectedProcessorCooler,
      psu_id: this.selectedPowerSupply,
      gpu_id: this.selectedGraphicsCard,
      ihd_id: this.selectedhardDrive,
      case_id: this.selectedCase
    };
  
    if (this.mode === 'modify' && this.configId) {
      (configData as any)['config_id'] = this.configId;
      this.http.put('http://localhost:8000/api/modifyconfig', configData, { headers }).subscribe(
        response => {
          console.log('Configuration updated:', response);
        },
        error => {
          console.error('Error updating configuration:', error);
        }
      );
    } else {
      this.http.post('http://localhost:8000/api/newconfig', configData, { headers }).subscribe(
        response => {
          console.log('Configuration saved:', response);
        },
        error => {
          console.error('Error saving configuration:', error);
        }
      );
    }
  }  

  fetchConfig(id: number): void {
    const token = localStorage.getItem('token');
    if (token) {
      const headers = { 'Authorization': `Bearer ${token}` };
      this.http.get<any>(`http://localhost:8000/api/configs/${id}`, { headers }).subscribe(
        data => {
          console.log('Received configuration data:', data);
      this.selectedProcessor = this.findComponentId(this.processors, data.cpu);
      this.selectedMotherboard = this.findComponentId(this.motherboards, data.motherboard);
      this.selectedMemory = this.findComponentId(this.memories, data.memory);
      this.selectedProcessorCooler = this.findComponentId(this.processorCoolers, data.cpu_cooler);
      this.selectedPowerSupply = this.findComponentId(this.powerSupplies, data.psu);
      this.selectedGraphicsCard = this.findComponentId(this.graphicsCards, data.gpu);
      this.selectedhardDrive = this.findComponentId(this.hardDrives, data.internal_hard_drive);
      this.selectedCase = this.findComponentId(this.cases, data.case);
    },
    error => {
      console.error('Error fetching config data:', error);
    }
  );
    } else {
      console.error('User not authenticated. Fetching config data requires authentication.');
    }
  }
  findComponentId(components: any[], name: string): number | null {
    const lowerCaseName = name.toLowerCase();
    const component = components.find(comp => {
      return Object.values(comp).some(value => {
        if (typeof value === 'string') {
          return value.toLowerCase() === lowerCaseName;
        }
        return false;
      });
    });
    return component ? component.id : null;
  }
}
