import { Injectable } from '@angular/core';

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

  toggleSelection(category: string, component: string): void {
    if (!this.selectedComponents[category]) {
      this.selectedComponents[category] = [];
    }

    const index = this.selectedComponents[category].indexOf(component);

    if (index === -1) {
      this.selectedComponents[category].push(component);
    } else {
      this.selectedComponents[category].splice(index, 1);
    }
  }
}






