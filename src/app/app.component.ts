import { Component } from '@angular/core';
import { PcBuilderService } from './pc-builder.service';


@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
})
export class AppComponent {
  constructor(private pcBuilderService: PcBuilderService) {}

  completeConfiguration(): void {
    // Add logic for what should happen when the configuration is complete
    // For example, send the selected components to a server, save them, or display a confirmation message.
  }
}
