import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { SignupService } from '../signup.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  loginForm: FormGroup;
  link = "./assets/site_logo.png";

  constructor(private formBuilder: FormBuilder, private signupService: SignupService) {
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
        // Check if the response contains the expected data object
        if (response.success && response.data && response.data.token) {
          const token = response.data.token;
          console.log('Token:', token);
          // Store the token in localStorage or session storage
          localStorage.setItem('token', token);
          // Redirect or perform any other action upon successful login
          // For example:
          // window.location.href = '/dashboard'; // Redirect to dashboard page
        } else {
          console.error('Token not found in the response:', response);
          // Handle error, e.g., show an error message to the user
        }
      },
      error => {
        console.error('Error:', error);
        // Handle error, e.g., show an error message to the user
      }
    );
  }
}
