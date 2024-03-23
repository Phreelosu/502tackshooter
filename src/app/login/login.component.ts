import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { SignupService } from '../signup.service'; // Import your SignupService

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
        // Handle successful response, e.g., show a success message
      },
      error => {
        console.error('Error:', error);
        // Handle error, e.g., show an error message
      }
    );
  }
}
