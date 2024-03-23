import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { SignupService } from '../signup.service'; // Import your SignupService

@Component({
  selector: 'app-signup',
  templateUrl: './sign-up.component.html',
  styleUrls: ['./sign-up.component.css']
})
export class SignupComponent implements OnInit {
  signupForm: FormGroup;
  link = "./assets/site_logo.png"

  constructor(private formBuilder: FormBuilder, private signupService: SignupService) {
    this.signupForm = this.formBuilder.group({
      name: ["", Validators.required],
      email: ["", [Validators.required, Validators.email]],
      password: ["", [Validators.required]],
      password_confirmation: ["", Validators.required]

    });
  }

  ngOnInit(): void {}

  signUp() {
    const formData = this.signupForm.value;
    this.signupService.signUp(formData).subscribe(
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