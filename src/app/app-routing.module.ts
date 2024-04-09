import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { BuilderComponent } from './builder/builder.component';
import { HowToComponent } from './how-to/how-to.component';
import { LoginComponent } from './login/login.component';
import { SignupComponent } from './sign-up/sign-up.component';
import { FooterComponent } from './footer/footer.component';
import { UserConfigsComponent } from './userconfigs/userconfigs.component';

const routes: Routes = [
  {
    path: '', 
    loadChildren: () => import('./public/public.module').then((m) => m.PublicModule) 
  },
  { path: 'home', component: HomeComponent },
  { path: 'builder', component: BuilderComponent },
  { path: 'how-to', component: HowToComponent },
  { path: 'login', component: LoginComponent },
  { path: 'sign-up', component: SignupComponent },
  { path: 'footer', component: FooterComponent }, 
  { path: 'userconfigs', component: UserConfigsComponent },
  { path: '**', redirectTo: '/home', pathMatch: 'full' }, // Redirect unmatched paths to home
]; 

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
