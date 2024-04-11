import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router'; 
import { SignupService } from '../signup.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  loginForm: FormGroup;
  link = "./assets/site_logo.png";

  constructor(private formBuilder: FormBuilder, 
              private signupService: SignupService,
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
          this.router.navigate(['/home']);
        } else {
          console.error('Token not found in the response:', response);
        }
      },
      error => {
        console.error('Error:', error);
      }
    );
  }
}