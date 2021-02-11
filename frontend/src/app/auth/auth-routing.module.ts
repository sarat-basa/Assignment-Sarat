import { NgModule } from '@angular/core';
import { Routes,RouterModule} from '@angular/router';
import {LoginComponent} from './login/login.component';

const routes:Routes = [
  {path:'auth/login',component:LoginComponent}
]
@NgModule({
  declarations: [],
  imports: [
    RouterModule.forChild(routes)
  ],
  exports:[RouterModule]
})
export class AuthRoutingModule { }
