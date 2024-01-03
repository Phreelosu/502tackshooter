import { Component, OnInit } from '@angular/core';
import { PcBuilderService } from '../pc-builder.service';

@Component({
  selector: 'app-selected-components',
  templateUrl: './selected-components.component.html',
  styleUrls: ['./selected-components.component.css'],
})
export class SelectedComponentsComponent implements OnInit {
  selectedComponents: string[];

  constructor(private pcBuilderService: PcBuilderService) {
    this.selectedComponents = this.pcBuilderService.selectedComponents;
  }

  ngOnInit(): void {}
}
