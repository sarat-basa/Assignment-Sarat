import { NgModule } from '@angular/core';
import {Routes,RouterModule} from '@angular/router';
import {DashboardComponent} from '../app/user/dashboard/dashboard.component';
import {EditDataComponent} from '../app/user/edit-data/edit-data.component';
import {RegisterComponent} from '../app/auth/register/register.component';
import {LoginComponent} from '../app/auth/login/login.component';
import { AddDetailsComponent } from "../app/user/add-details/add-details.component";

const routes : Routes = [
  {path : '',redirectTo:'/auth/login', pathMatch:'full'},
  {path : 'user/dashboard', component:DashboardComponent,},
  {path : 'user/edit-data/:id',component:EditDataComponent},
  {path : 'user/add-details',component:AddDetailsComponent},
  {path : 'auth/register',component: RegisterComponent},
  {path : 'auth/login',component : LoginComponent}
];

@NgModule({
  declarations: [],
  imports: [RouterModule.forRoot(routes)],
  exports:[RouterModule]
})
export class AppRoutingModule { }
