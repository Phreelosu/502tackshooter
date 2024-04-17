import { Component, OnInit } from '@angular/core';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthService } from '../auth.service';
import { SignupService } from '../signup.service';
import { Observable } from 'rxjs/internal/Observable';
import { catchError, forkJoin, map, switchMap, tap, throwError } from 'rxjs';

interface ApiResponse {
  success: boolean;
  data: any; // Adjust the type of data as per your API response structure
  message: string; // Add a message property
}

interface Processor {
  id: number;
  CPU_name: string;
  CPU_price: number;
  CPU_core_count: number;
  CPU_core_clock: number;
  CPU_boost_clock: number;
  CPU_graphics: string;
}

interface Cooler {
  id: number;
  Cooler_name: string;
  Cooler_price: number;
  Cooler_RPM_Min: number;
  Cooler_RPM_Max: number;
  Cooler_color_ID: number;
  Cooler_color_name: string;
}

interface Memory {
  id: number;
  Memory_name: string;
  Memory_price: number;
  Memory_speed: number;
  Memory_modules_ID: number;
  Memory_modules: string;
  Memory_color_ID: number;
  Memory_color_name: string;
  First_word_latency: number;
  CAS_latency: number;
}

interface Motherboard {
  id: number;
  Motherboard_name: string;
  Motherboard_price: number;
  Motherboard_socket: string;
  Motherboard_form_factor_ID: number;
  Motherboard_form_factor: string;
  Motherboard_max_memory_ID: number;
  Motherboard_max_memory: string;
  Motherboard_memory_slots_ID: number;
  Motherboard_memory_slots: string;
  Motherboard_color_ID: number;
  Motherboard_color: string;
}

interface GraphicsCard {
  id: number;
  GPU_name: string;
  GPU_price: number;
  GPU_chipset: string;
  GPU_memory_ID: number;
  GPU_memory: string;
  GPU_core_clock: string;
  GPU_boost_clock: string;
  GPU_color_ID: number;
  GPU_color: string;
  GPU_length: number;
}

interface IHD {
  id: number;
  Hard_drive_name: string;
  Hard_drive_price: number;
  Hard_drive_capacity_ID: number;
  Hard_drive_capacity: string;
  Hard_drive_type_ID: number;
  Hard_drive_type: string;
  Hard_drive_cache: number;
  Hard_drive_form_factor_ID: number;
  Hard_drive_form_factor: string;
  Hard_drive_interface_ID: number;
  Hard_drive_interface: string;
}

@Component({
  selector: 'app-builder',
  templateUrl: './builder.component.html',
  styleUrls: ['./builder.component.css']
})
export class BuilderComponent implements OnInit {
  processors: any[] = [];
  processorDetails: Processor | null = null;
  motherboards: any[] = [];
  motherboardDetails: Motherboard | null = null;
  memories: any[] = [];
  memoryDetails: Memory | null = null;
  processorCoolers: any[] = [];
  coolerDetails: Cooler | null = null;
  powerSupplies: any[] = [];
  graphicsCards: any[] = [];
  graphicsCardDetails: GraphicsCard | null = null;
  hardDrives: any[] = [];
  hardDriveDetails: IHD | null = null;
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
  successMessage: string | null = null;
  errorMessage: string | null = null;

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
        this.processors = data;
      },
      error => {
        console.error('Error fetching CPU data:', error);
      }
    );
  }

  fetchProcessorDetails(processorId: number): Observable<Processor> {
    return this.http.get<Processor>(`http://localhost:8000/api/cpu/${processorId}`).pipe(
      catchError(error => {
        console.error('Error fetching processor details:', error);
        return throwError(error);
      })
    );
  }
  

  updateProcessorDetails(processorId: number | null): void {
    if (processorId !== null) {
        // Fetch processor details
        this.fetchProcessorDetails(processorId).subscribe(
            (data) => {
                this.processorDetails = data;
            },
            (error) => {
                console.error('Error fetching processor details:', error);
                this.processorDetails = null;
            }
        );
    } else {
        this.processorDetails = null;
    }
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

  fetchMotherboardDetails(motherboardId: number): Observable<Motherboard> {
    // Fetch motherboard details
    const motherboard$ = this.http.get<Motherboard>(`http://localhost:8000/api/motherboard/${motherboardId}`);
  
    // Switch to fetching form factor based on the motherboard's form factor ID
    const formFactor$ = motherboard$.pipe(
      switchMap(motherboard => {
        return this.http.get<any>(`http://localhost:8000/api/mobo_form_factor/${motherboard.Motherboard_form_factor_ID}`).pipe(
          map(response => response.MOBO_Form_Factor),
          catchError(error => {
            console.error('Error fetching motherboard form factor:', error);
            return throwError(error);
          })
        );
      })
    );
  
    // Switch to fetching max memory based on the motherboard's max memory ID
    const maxMemory$ = motherboard$.pipe(
      switchMap(motherboard => {
        return this.http.get<any>(`http://localhost:8000/api/mobo_max_memory/${motherboard.Motherboard_max_memory_ID}`).pipe(
          map(response => response.MOBO_Max_Memory),
          catchError(error => {
            console.error('Error fetching motherboard max memory:', error);
            return throwError(error);
          })
        );
      })
    );
  
    // Switch to fetching memory slots based on the motherboard's memory slots ID
    const memorySlots$ = motherboard$.pipe(
      switchMap(motherboard => {
        return this.http.get<any>(`http://localhost:8000/api/mobo_memory_slots/${motherboard.Motherboard_memory_slots_ID}`).pipe(
          map(response => response.MOBO_Memory_Slots),
          catchError(error => {
            console.error('Error fetching motherboard memory slots:', error);
            return throwError(error);
          })
        );
      })
    );

    const color$ = motherboard$.pipe(
      switchMap(motherboard => {
        return this.fetchColorName(motherboard.Motherboard_color_ID).pipe(
          map(colorName => colorName.Color),
          catchError(error => {
            console.error('Error fetching motherboard color:', error);
            return throwError(error);
          })
        );
      })
    );
  
    // Combine all observables and map the results
    return forkJoin({ motherboard: motherboard$, color: color$, formFactor: formFactor$, maxMemory: maxMemory$, memorySlots: memorySlots$ }).pipe(
      map(({ motherboard, color, formFactor, maxMemory, memorySlots }) => {
        // Map additional properties to the motherboard object
        motherboard.Motherboard_color = color;
        motherboard.Motherboard_form_factor = formFactor;
        motherboard.Motherboard_max_memory = maxMemory;
        motherboard.Motherboard_memory_slots = memorySlots;
        return motherboard;
      }),
      catchError(error => {
        console.error('Error fetching motherboard details:', error);
        return throwError(error);
      })
    );
  }
  

  updateMotherboardDetails(motherboardId: number | null): void {
    if (motherboardId) {
      this.fetchMotherboardDetails(motherboardId).subscribe(
        (data) => {
          this.motherboardDetails = data;
        },
        (error) => {
          console.error('Error fetching motherboard details:', error);
          this.motherboardDetails = null;
        }
      );
    } else {
      this.motherboardDetails = null;
    }
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

  fetchMemoryDetails(memoryId: number): Observable<Memory> {
    return this.http.get<Memory>(`http://localhost:8000/api/memory/${memoryId}`).pipe(
      switchMap(memory => {
        // Fetch color name based on Memory_color_ID
        const colorName$ = this.fetchColorName(memory.Memory_color_ID).pipe(
          map(colorName => colorName.Color),
          catchError(error => {
            console.error('Error fetching color name:', error);
            return throwError(error);
          })
        );
  
        // Fetch memory module name based on Memory_modules_ID
        const moduleName$ = this.fetchMemoryModules(memory.Memory_modules_ID).pipe(
          map(moduleName => moduleName.MemoryModule),
          catchError(error => {
            console.error('Error fetching memory module name:', error);
            return throwError(error);
          })
        );
  
        // Combine the color and module names into the memory object
        return forkJoin([colorName$, moduleName$]).pipe(
          map(([colorName, moduleName]) => {
            memory.Memory_color_name = colorName;
            memory.Memory_modules = moduleName; // Directly assign moduleName
            return memory;
          }),                    
          catchError(error => {
            console.error('Error combining color and module names:', error);
            return throwError(error);
          })
        );
      }),
      catchError(error => {
        console.error('Error fetching memory details:', error);
        return throwError(error);
      })
    );
  }

  fetchMemoryModules(memoryModuleId: number): Observable<{ MemoryModule: string }> {
    return this.http.get<any>(`http://localhost:8000/api/memory_modules/${memoryModuleId}`).pipe(
      map(response => ({ MemoryModule: response.memory_modules.split(',') })), // Split the string into an array
      catchError(error => {
        console.error('Error fetching memory module name:', error);
        return throwError(error);
      })
    );
  }  
  

  updateMemoryDetails(memoryId: number | null): void {
    if (memoryId) {
        this.fetchMemoryDetails(memoryId).subscribe(
            (data) => {
                this.memoryDetails = data;
            },
            (error) => {
                console.error('Error fetching memory details:', error);
                this.memoryDetails = null;
            }
        );
    } else {
        this.memoryDetails = null;
    }
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

  updateCoolerDetails(coolerId: number | null): void {
    if (coolerId) {
        this.fetchCoolerDetails(coolerId).subscribe(
            (data) => {
                this.coolerDetails = data;
            },
            (error) => {
                console.error('Error fetching cooler details:', error);
                this.coolerDetails = null;
            }
        );
    } else {
        this.coolerDetails = null;
    }
}

fetchCoolerDetails(coolerId: number): Observable<Cooler> {
  return this.http.get<Cooler>(`http://localhost:8000/api/cpu_cooler/${coolerId}`).pipe(
    switchMap(cooler => {
      // Fetch the color name based on Cooler_color_ID
      return this.fetchColorName(cooler.Cooler_color_ID).pipe(
        map(colorName => {
          // Include only the "Color" value in the cooler object
          cooler.Cooler_color_name = colorName.Color;
          return cooler;
        })
      );
    }),
    catchError(error => {
      console.error('Error fetching cooler details:', error);
      return throwError(error);
    })
  );
}

fetchColorName(colorId: number): Observable<{ Color: string }> {
  return this.http.get<{ Color: string }>(`http://localhost:8000/api/colors/${colorId}`).pipe(
    catchError(error => {
      console.error('Error fetching color name:', error);
      return throwError(error);
    })
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

  fetchGPUDetails(gpuId: number): Observable<GraphicsCard> {
    // Fetch GPU details
    const gpu$ = this.http.get<GraphicsCard>(`http://localhost:8000/api/gpu/${gpuId}`);
  
    // Fetch GPU memory details
    const memory$ = gpu$.pipe(
      switchMap(gpu => {
        return this.fetchGPUMemory(gpu.GPU_memory_ID).pipe(
          map(memoryDetails => memoryDetails.GPU_Memory),
          catchError(error => {
            console.error('Error fetching GPU memory details:', error);
            return throwError(error);
          })
        );
      })
    );
  
    // Fetch GPU color details
    const color$ = gpu$.pipe(
      switchMap(gpu => {
        return this.fetchColorName(gpu.GPU_color_ID).pipe(
          map(colorName => colorName.Color),
          catchError(error => {
            console.error('Error fetching GPU color:', error);
            return throwError(error);
          })
        );
      })
    );
  
    // Combine GPU details with memory and color
    return forkJoin({ gpu: gpu$, memory: memory$, color: color$ }).pipe(
      map(({ gpu, memory, color }) => {
        // Assign memory and color to the GPU object
        gpu.GPU_memory = memory;
        gpu.GPU_color = color;
        return gpu;
      }),
      catchError(error => {
        console.error('Error fetching GPU details:', error);
        return throwError(error);
      })
    );
  }
   
  
  fetchGPUMemory(gpumemoryId: number): Observable<{ GPU_Memory: string }> {
    return this.http.get<{ GPU_Memory: string }>(`http://localhost:8000/api/gpu_memory/${gpumemoryId}`).pipe(
      catchError(error => {
        console.error('Error fetching GPU memory:', error);
        return throwError(error);
      })
    );
  }  
  

  updateGraphicsCardDetails(graphicsCardId: number | null): void {
    if (graphicsCardId) {
      this.fetchGPUDetails(graphicsCardId).subscribe(
        (data) => {
          this.graphicsCardDetails = data;
        },
        (error) => {
          console.error('Error fetching GPU details:', error);
          this.graphicsCardDetails = null;
        }
      );
    } else {
      this.graphicsCardDetails = null;
    }
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

  fetchHardDriveDetails(hardDriveId: number): Observable<IHD> {
    return this.http.get<IHD>(`http://localhost:8000/api/internal_hard_drive/${hardDriveId}`).pipe(
      switchMap(hardDrive => {
        // Fetch the hard drive capacity
        const capacity$ = this.fetchIhdCapacity(hardDrive.Hard_drive_capacity_ID).pipe(
          catchError(error => {
            console.error('Error fetching hard drive capacity:', error);
            return throwError(error);
          })
        );

        const type$ = this.fetchIhdType(hardDrive.Hard_drive_type_ID).pipe(
          catchError(error => {
            console.error('Error fetching hard drive type:', error);
            return throwError(error);
          })
        );
  
        // Fetch the hard drive form factor
        const formFactor$ = this.fetchIhdFormFactor(hardDrive.Hard_drive_form_factor_ID).pipe(
          catchError(error => {
            console.error('Error fetching hard drive form factor:', error);
            return throwError(error);
          })
        );
  
        // Fetch the hard drive interface
        const interfaceType$ = this.fetchIhdInterface(hardDrive.Hard_drive_interface_ID).pipe(
          catchError(error => {
            console.error('Error fetching hard drive interface:', error);
            return throwError(error);
          })
        );
  
        // Combine all observables and map the results
        return forkJoin([capacity$, formFactor$, interfaceType$, type$]).pipe(
          map(([capacity, formFactor, interfaceType, type]) => {
            // Map additional properties to the hard drive object
            hardDrive.Hard_drive_capacity = capacity;
            hardDrive.Hard_drive_form_factor = formFactor;
            hardDrive.Hard_drive_interface = interfaceType;
            hardDrive.Hard_drive_type = type;
            return hardDrive;
          }),
          catchError(error => {
            console.error('Error combining hard drive details:', error);
            return throwError(error);
          })
        );
      }),
      catchError(error => {
        console.error('Error fetching hard drive details:', error);
        return throwError(error);
      })
    );
  }

  updateHardDriveDetails(hardDriveId: number | null): void {
    if (hardDriveId) {
      this.fetchHardDriveDetails(hardDriveId).subscribe(
        (data) => {
          this.hardDriveDetails = data;
          this.updateHardDriveProperties(data);
        },
        (error) => {
          console.error('Error fetching hard drive details:', error);
          this.hardDriveDetails = null;
        }
      );
    } else {
      this.hardDriveDetails = null;
    }
  }
  
  private updateHardDriveProperties(hardDrive: IHD): void {
    forkJoin({
      capacity: this.fetchIhdCapacity(hardDrive.Hard_drive_capacity_ID),
      type: this.fetchIhdType(hardDrive.Hard_drive_type_ID),
      formFactor: this.fetchIhdFormFactor(hardDrive.Hard_drive_form_factor_ID),
      interface: this.fetchIhdInterface(hardDrive.Hard_drive_interface_ID)
    }).subscribe(
      (data) => {
        this.hardDriveDetails!.Hard_drive_capacity = data.capacity;
        this.hardDriveDetails!.Hard_drive_type = data.type;
        this.hardDriveDetails!.Hard_drive_form_factor = data.formFactor;
        this.hardDriveDetails!.Hard_drive_interface = data.interface;
      },
      (error) => {
        console.error('Error updating internal hard drive properties:', error);
      }
    );
  }
  

  fetchIhdCapacity(capacityId: number): Observable<string> {
    return this.http.get<{ IHD_Capacity: string }>(`http://localhost:8000/api/ihd_capacity/${capacityId}`).pipe(
      map(response => response.IHD_Capacity),
      catchError(error => {
        console.error('Error fetching internal hard drive capacity:', error);
        return throwError(error);
      })
    );
  }
  
  fetchIhdType(typeId: number): Observable<string> {
    return this.http.get<{ IHD_Type: string }>(`http://localhost:8000/api/ihd_type/${typeId}`).pipe(
      map(response => response.IHD_Type),
      catchError(error => {
        console.error('Error fetching internal hard drive type:', error);
        return throwError(error);
      })
    );
  }
  
  fetchIhdFormFactor(formFactorId: number): Observable<string> {
    return this.http.get<{ ihd_form_factor: string }>(`http://localhost:8000/api/ihd_form_factor/${formFactorId}`).pipe(
      map(response => response.ihd_form_factor),
      catchError(error => {
        console.error('Error fetching internal hard drive form factor:', error);
        return throwError(error);
      })
    );
  }
  
  fetchIhdInterface(interfaceId: number): Observable<string> {
    return this.http.get<{ ihd_interface: string }>(`http://localhost:8000/api/ihd_interface/${interfaceId}`).pipe(
      map(response => response.ihd_interface),
      catchError(error => {
        console.error('Error fetching internal hard drive interface:', error);
        return throwError(error);
      })
    );
  }
  
  

  fetchCases(): void {
    this.http.get<any[]>('http://localhost:8000/api/pc_case').subscribe(
      data => {
        this.cases = data;
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
  
    // Check if any dropdowns have their default values selected
    const notSelectedParts: string[] = [];
    if (!this.selectedProcessor) {
      notSelectedParts.push('Processor');
    }
    if (!this.selectedMotherboard) {
      notSelectedParts.push('Motherboard');
    }
    if (!this.selectedMemory) {
      notSelectedParts.push('Memory');
    }
    if (!this.selectedProcessorCooler) {
      notSelectedParts.push('Processor Cooler');
    }
    if (!this.selectedPowerSupply) {
      notSelectedParts.push('Power Supply');
    }
    if (!this.selectedGraphicsCard) {
      notSelectedParts.push('Graphics Card');
    }
    if (!this.selectedhardDrive) {
      notSelectedParts.push('Hard Drive');
    }
    if (!this.selectedCase) {
      notSelectedParts.push('Case');
    }
  
    // If any parts are not selected, display an error message
    if (notSelectedParts.length > 0) {
      this.errorMessage = `Please select the following parts: ${notSelectedParts.join(', ')}`;
      // Clear any previous success message
      this.successMessage = null;
      return;
    }
  
    // If all parts are selected, proceed with saving the configuration
    if (this.mode === 'modify' && this.configId) {
      (configData as any)['config_id'] = this.configId;
      this.http.put<ApiResponse>('http://localhost:8000/api/modifyconfig', configData, { headers }).subscribe(
        response => {
          console.log('Configuration updated:', response);
          this.successMessage = response.message; // Set success message from response
          // Clear any previous error message
          this.errorMessage = null;
        },
        error => {
          console.error('Error updating configuration:', error);
          this.errorMessage = error.message; // Set error message from error object
          // Clear any previous success message
          this.successMessage = null;
        }
      );
    } else {
      this.http.post<ApiResponse>('http://localhost:8000/api/newconfig', configData, { headers }).subscribe(
        response => {
          console.log('Configuration saved:', response);
          this.successMessage = response.message; // Set success message from response
          // Clear any previous error message
          this.errorMessage = null;
        },
        error => {
          console.error('Error saving configuration:', error);
          this.errorMessage = error.message; // Set error message from error object
          // Clear any previous success message
          this.successMessage = null;
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
      this.updateProcessorDetails(this.selectedProcessor);
      this.selectedMotherboard = this.findComponentId(this.motherboards, data.motherboard);
      this.selectedMemory = this.findComponentId(this.memories, data.memory);
      this.updateMemoryDetails(this.selectedMemory);
      this.selectedProcessorCooler = this.findComponentId(this.processorCoolers, data.cpu_cooler);
      this.updateCoolerDetails(this.selectedProcessorCooler);
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
