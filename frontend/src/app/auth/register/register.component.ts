import { Component, OnInit } from '@angular/core';
import { FormControl,FormGroup,Validators } from '@angular/forms';
import { AuthService } from '../auth.service';
import {Router} from '@angular/router';
import { ToastrService } from 'ngx-toastr';
@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {

    signupForm = new FormGroup({
    emailId: new FormControl('',[Validators.required,Validators.pattern("^[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,4}$")]),
    password: new FormControl('',[Validators.required]),
    confirmPass : new FormControl('',[Validators.required]),
  });
  constructor(
    private authService: AuthService,
    private router: Router,
    private toastr : ToastrService
  ) { }

  ngOnInit(): void {
  }
 
  register = () => {
    const email_id = this.signupForm.value.emailId;
    const password = this.signupForm.value.password;
    const confirmPass = this.signupForm.value.confirmPass;
    if(password == confirmPass) {
      this.authService.register(email_id, password).subscribe((data) => {
            if(data.status == true){
              this.toastr.success('you have Succesfully Register !! Please Sign in');
              this.signupForm.reset('');
            }
            else{
              this.toastr.error("User Already Exist");
            }
        },
      // error => this.toastr.error(error)
      );
    } else{
      this.toastr.error('Password does not matched');
    } 
  }

}
