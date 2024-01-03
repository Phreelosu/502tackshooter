// selected-components.component.ts

import { Component, OnInit } from '@angular/core';
import { PcBuilderService } from '../pc-builder.service';

@Component({
  selector: 'app-selected-components',
  templateUrl: './selected-components.component.html',
  styleUrls: ['./selected-components.component.css'],
})
export class SelectedComponentsComponent implements OnInit {
  selectedComponents: any = {};
  availableComponents: any = {}; // Assuming you have a property for available components

  constructor(private pcBuilderService: PcBuilderService) {}

  ngOnInit(): void {
    // Subscribe to changes in selectedComponents
    this.pcBuilderService.getSelectedComponentsObservable().subscribe((selectedComponents) => {
      this.selectedComponents = selectedComponents;
    });

    // Get the available components from the service
    this.availableComponents = this.pcBuilderService.components;
  }

  getCategoryKeys(): string[] {
    return Object.keys(this.availableComponents);
  }
  getSelectedComponentsArray(): string[] {
    return Object.values(this.selectedComponents);
  }
}
