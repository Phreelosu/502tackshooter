// pc-components.component.ts

import { Component, OnInit } from '@angular/core';
import { PcBuilderService } from '../pc-builder.service';

@Component({
  selector: 'app-pc-components',
  templateUrl: './pc-components.component.html',
  styleUrls: ['./pc-components.component.css'],
})
export class PcComponentsComponent implements OnInit {
  components: any;
  selectedCpu: string = '';
  selectedComponents: any = {};

  constructor(private pcBuilderService: PcBuilderService) {
    this.components = this.pcBuilderService.components;

    // Subscribe to changes in selectedComponents
    this.pcBuilderService.getSelectedComponentsObservable().subscribe((selectedComponents) => {
      this.selectedComponents = selectedComponents;
      console.log('Selected Components:', this.selectedComponents);
    });
  }

  toggleSelection(category: string, component: string): void {
    if (category === 'cpu') {
      this.selectedCpu = component;
      this.pcBuilderService.toggleSelection(category, component);
    } else {
      this.pcBuilderService.toggleSelection(category, component);
    }
  }

  getCategoryKeys(): string[] {
    return Object.keys(this.components);
  }

  ngOnInit(): void {}
}
