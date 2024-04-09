import { Component, OnInit } from '@angular/core';
import { ConfigService } from '../config.service';
import { Config } from '../config.model';
import { Router } from '@angular/router';

@Component({
  selector: 'app-user-configs',
  templateUrl: './userconfigs.component.html',
  styleUrls: ['./userconfigs.component.css']
})
export class UserConfigsComponent implements OnInit {
  configs: Config[] = [];

  constructor(private configService: ConfigService, private router: Router) { }

  ngOnInit(): void {
    this.loadConfigs();
  }

  loadConfigs(): void {
    this.configService.getUserConfigs().subscribe(
      configs => {
        this.configs = configs;
      },
      error => {
        console.error('Error loading user configs:', error);
      }
    );
  }

  modifyConfig(configId: number): void {
  // Navigate to the builder page with the config ID
  this.router.navigate(['/builder', configId]);
}

  deleteConfig(configId: number): void {
    this.configService.deleteConfig(configId).subscribe(
      () => {
        // Refresh the configs after successful deletion
        this.loadConfigs();
      },
      error => {
        console.error('Error deleting config:', error);
      }
    );
  }
}
