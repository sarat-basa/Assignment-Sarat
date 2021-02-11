import { Component, OnInit } from '@angular/core';
import {Router} from '@angular/router';
import{ AuthService} from '../../auth/auth.service';
import { HttpHeaders } from '@angular/common/http';
@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {
reqData:any = [];
  constructor(
    private router: Router,
    private authService : AuthService
  ) { }

  ngOnInit(): void {
    this.authService.getRequestType().subscribe(
      (data) => {
        console.log(data);
        this.reqData= data.data;
      }
    );
  }
  btnEdit(id: number){
    //console.log(id);return;
    this.router.navigate(['/user/edit-data/'+id]);
  }

  btnAdd (){
    this.router.navigate(['/user/add-details']);
  }
  logout(){
    this.authService.logout();
  }
}
