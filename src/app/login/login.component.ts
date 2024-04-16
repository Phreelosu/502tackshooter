import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router'; 
import { SignupService } from '../signup.service';
import { AuthService } from '../auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  loginForm: FormGroup;
  link = "./assets/site_logo.png";
  message: string | null = null;
  success: boolean | null = null;

  constructor(private formBuilder: FormBuilder, 
              private signupService: SignupService,
              private authService: AuthService,
              private router: Router) { 
    this.loginForm = this.formBuilder.group({
      email: ["", [Validators.required, Validators.email]],
      password: ["", [Validators.required]]
    });
  }

  ngOnInit(): void {}

  logIn() {
    const formData = this.loginForm.value;
    this.signupService.logIn(formData).subscribe(
      response => {
        console.log('Response:', response);
        if (response.success && response.data && response.data.token) {
          let token = response.data.token;
          token = token.split('|')[1];
          console.log('Token:', token);
          localStorage.setItem('token', token);
          this.authService.emitLoginSuccessMessage('Login successful'); // Emit success message
          this.authService.emitLoginStatusChange(true); // Emit login status change
          this.router.navigate(['/home']);
        } else {
          console.error('Token not found in the response:', response);
          this.message = response.message || 'Login failed'; // Set error message from response or default message
          this.success = false;
        }
      },
      error => {
        console.error('Error:', error);
        if (error.error && error.error.errormessage && Array.isArray(error.error.errormessage) && error.error.errormessage.length > 0) {
          this.message = error.error.errormessage[0]; // Set specific error message from response
        } else {
          this.message = 'Error occurred while logging in'; // Set generic error message
        }
        this.success = false;
      }
    );
  }
  
  
}
