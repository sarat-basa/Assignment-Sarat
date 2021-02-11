
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { ToastrModule } from 'ngx-toastr';
import { AppComponent } from './app.component';
import { AppRoutingModule } from './app-routing.module';
import {AuthModule } from './auth/auth.module'
import { CommonModule } from '@angular/common';  
import { ReactiveFormsModule} from "@angular/forms";
import { FormsModule } from '@angular/forms';
import {  UserModule} from "./user/user.module";


@NgModule({
  declarations: [
    AppComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    AuthModule,
    FormsModule,
    UserModule,
    BrowserAnimationsModule,
    ReactiveFormsModule,
     ToastrModule.forRoot()
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
