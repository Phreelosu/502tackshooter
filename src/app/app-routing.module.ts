import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { HomeComponent } from './home/home.component';
import { HeaderComponent } from './header/header.component';
import { BuilderComponent } from './builder/builder.component';
import { HowToComponent } from './how-to/how-to.component';
import { LoginComponent } from './login/login.component';
import { SignUpComponent } from './sign-up/sign-up.component';
import { FooterComponent } from './footer/footer.component';

const routes: Routes = [
  {
    path: '', 
    loadChildren: ()=>
      import('./public/public.module').then((m)=>m.PublicModule) },
  { path: 'home', component: HomeComponent },
  { path: 'builder', component: BuilderComponent },
  { path: 'how-to', component: HowToComponent },
  { path: 'login', component: LoginComponent },
  { path: 'sign-up', component: SignUpComponent },
  { path: 'footer', component: FooterComponent },
]; 

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule{
 
}
