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
    this.selectedComponents = this.pcBuilderService.selectedComponents;
  }

  toggleSelection(category: string, component: string): void {
    if (category === 'cpu') {
      this.selectedCpu = component;
    } else {
      this.pcBuilderService.toggleSelection(category, component);
      this.selectedComponents = this.pcBuilderService.selectedComponents; // Update the local selectedComponents
    }
  }

  getCategoryKeys(): string[] {
    return Object.keys(this.components);
  }

  ngOnInit(): void {}
}



