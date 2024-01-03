import { Injectable } from '@angular/core';
import { BehaviorSubject, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class PcBuilderService {
  components = {
    cpu: ['Intel i9', 'AMD Ryzen 9', 'Intel i7'], // Updated CPU component names
    gpu: ['ASUS RTX4090', 'GIGABYTE RTX3080', 'ASUS RX6800XT'],
    ram: ['RAM1', 'RAM2', 'RAM3'],
    storage: ['SSD1', 'SSD2', 'HDD1'],
    // Add more components as needed
  };

  selectedComponents: any = {};

  private selectedComponentsSubject = new BehaviorSubject<any>(this.selectedComponents);

  constructor() {
    // Initialize components and selectedComponents as needed
  }

  toggleSelection(category: string, component: string): void {
    // Your logic for updating selectedComponents
    this.selectedComponents[category] = component;
    this.selectedComponentsSubject.next({ ...this.selectedComponents }); // Emit the updated selectedComponents
    console.log('Selected Components Updated:', this.selectedComponents);
  }

  getSelectedComponentsObservable(): Observable<any> {
    return this.selectedComponentsSubject.asObservable();
  }
}






