import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';

import { AppComponent } from './app.component';
import { PcComponentsComponent } from './pc-components/pc-components.component';
import { SelectedComponentsComponent } from './selected-components/selected-components.component';
import { PcBuilderService } from './pc-builder.service';

@NgModule({
  declarations: [
    AppComponent,
    PcComponentsComponent,
    SelectedComponentsComponent,
  ],
  imports: [
    BrowserModule,
    FormsModule,
  ],
  providers: [PcBuilderService], // Make sure the service is provided here
  bootstrap: [AppComponent],
})
export class AppModule {}
