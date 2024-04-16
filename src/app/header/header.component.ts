import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../auth.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {
  isLoggedIn = false;
  showSuccessMessage = false;
  successMessage: string = '';

  constructor(private authService: AuthService, private router: Router) {}

  ngOnInit(): void {
    // Subscribe to changes in login status and display the success message
    this.authService.loginSuccessEvent.subscribe(message => {
      this.showSuccessMessage = true;
      this.successMessage = message;
      setTimeout(() => {
        this.showSuccessMessage = false;
        this.successMessage = '';
      }, 3000);
    });

    // Subscribe to changes in signup success event and display the success message
    this.authService.signupSuccessEvent.subscribe(message => {
      this.showSuccessMessage = true;
      this.successMessage = message;
      setTimeout(() => {
        this.showSuccessMessage = false;
        this.successMessage = '';
      }, 3000);
    });

    // Refresh header component on initialization
    this.router.events.subscribe(() => {
      this.isLoggedIn = this.authService.isLoggedIn();
    });
  }

  logout(): void {
    this.authService.logout();
    this.isLoggedIn = false;
    this.showSuccessMessage = true;
    this.successMessage = 'Successful logout';
    setTimeout(() => {
      this.showSuccessMessage = false;
      this.successMessage = '';
    }, 3000);
    this.router.navigate(['/home']);
  }  
}
