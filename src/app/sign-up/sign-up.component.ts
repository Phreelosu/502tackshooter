import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { SignupService } from '../signup.service';
import { AuthService } from '../auth.service'; // Import AuthService

@Component({
  selector: 'app-signup',
  templateUrl: './sign-up.component.html',
  styleUrls: ['./sign-up.component.css']
})
export class SignupComponent implements OnInit {
  signupForm: FormGroup;
  link = "./assets/site_logo.png";
  message: string | null = null;
  success: boolean | null = null;

  constructor(
    private formBuilder: FormBuilder,
    private signupService: SignupService,
    private authService: AuthService, // Inject AuthService
    private router: Router
  ) {
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
        if (response.success) {
          this.authService.emitSignupSuccessMessage('Signup successful'); // Emit signup success message
          this.router.navigate(['/login']);
        } else {
          this.message = response.message || 'Sign up failed';
          this.success = false;
        }
      },
      error => {
        console.error('Error:', error);
        this.message = 'Error occurred while signing up';
        this.success = false;
      }
    );
  }
}
