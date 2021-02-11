import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { DashboardComponent } from './dashboard/dashboard.component';
import { EditDataComponent } from './edit-data/edit-data.component';
import { AddDetailsComponent } from './add-details/add-details.component';
import { AuthRoutingModule } from '../auth/auth-routing.module';
import { HttpClientModule } from "@angular/common/http";
import { FormsModule, ReactiveFormsModule} from "@angular/forms";
import { ToastrModule } from 'ngx-toastr';



@NgModule({
  declarations: [DashboardComponent, EditDataComponent, AddDetailsComponent],
  imports: [
    CommonModule,
    FormsModule,
    AuthRoutingModule,
    HttpClientModule,
    ReactiveFormsModule,
    ToastrModule

  ]
})

export class UserModule { }
