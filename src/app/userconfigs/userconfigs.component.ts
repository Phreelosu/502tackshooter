import { Component, OnInit } from '@angular/core';
import { ConfigService } from '../config.service';
import { Config } from '../config.model';

@Component({
  selector: 'app-user-configs',
  templateUrl: './userconfigs.component.html',
  styleUrls: ['./userconfigs.component.css']
})
export class UserConfigsComponent implements OnInit {
  configs: Config[] = [];

  constructor(private configService: ConfigService) { }

  ngOnInit(): void {
    this.loadConfigs();
  }

  loadConfigs(): void {
    this.configService.getUserConfigs().subscribe(configs => {
      this.configs = configs;
    });
  }
}
