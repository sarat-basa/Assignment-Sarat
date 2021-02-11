import { Component, OnInit } from '@angular/core';
import { FormControl,FormGroup,Validators} from '@angular/forms';
import { AuthService } from '../auth.service';
import {Router} from '@angular/router';
import { ToastrService } from 'ngx-toastr';
@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  loginForm = new FormGroup({
    emailId: new FormControl('',[Validators.required,Validators.pattern("^[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,4}$")]),
    password: new FormControl('',[Validators.required])
  });


  constructor(
    private toastr: ToastrService,
    private authService: AuthService,
    private router: Router
  ) { }

  ngOnInit(): void {
  }
   login = () => {
    const email_id = this.loginForm.value.emailId;
    const password = this.loginForm.value.password;
 
    this.authService.login(email_id, password).subscribe((data) => {
          if(data.status == true){
             this.toastr.success('you have succesfully login');
             
            this.router.navigate(['/user/dashboard']);
          }
          else{
            this.toastr.error('Failed to login');
          }
        }
    );
  }
}
