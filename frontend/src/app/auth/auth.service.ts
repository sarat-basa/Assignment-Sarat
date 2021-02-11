import { Injectable } from '@angular/core';
import { HttpClient, HttpErrorResponse, HttpHeaders } from '@angular/common/http';
import { map, catchError } from 'rxjs/operators';
import {Router} from '@angular/router';
@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(
    private http: HttpClient,
    private router: Router
  ) { }
  
  login = (email_id: string, password: string) => {
    const httpOptions = {
      headers: new HttpHeaders({
        'Content-Type': 'application/json'
      })
    };
    const data = {
      email_id: email_id, password: password
    }
    return this.http.post<any>('http://localhost/backend/auth/login', data, httpOptions)
      .pipe(map(user => {
          if(user) {
            if(user.data != undefined){
               localStorage.setItem('auth_token', user.data.token);
               localStorage.setItem('user_code', user.data.user_code);
               localStorage.setItem('email_id', user.data.email_id);
               return user;
            }else{
               user['status']=false
               return user;
            }  
          }else{
              user['status']=false
            return user;
          }
          
        }),
      );
  }

    register = (email_id: string, password: string) => {
      const httpOptions = {
        headers: new HttpHeaders({
          'Content-Type': 'application/json'
        })
      };
      const data = {
        email_id: email_id, password: password
      }
    return this.http.post<any>('http://localhost/backend/auth/signup', data, httpOptions)
      .pipe(map(user => {
        console.log(user);
            if(user.status == true){
              console.log('success')
               return user;
            }else{
               console.log('failed');
                console.log(user);
               user['status']=false
               return user;
            }  
        }),
      );
  }

  submitRequest = (formdata: any, url: string, method: string) => {
    const httpOptions = {
      headers: new HttpHeaders({
        'Authorization': `Bearer `+localStorage.getItem('auth_token')
      }),
    };

     return this.http
        .post<any>(url, formdata, httpOptions)
        .pipe(
          map((data) => {
            return data;
          }),
        );
  };
  editRequestType = (id:number) => {
    const httpOptions = {
      headers: new HttpHeaders({
        'Authorization': `Bearer `+localStorage.getItem('auth_token')
      }),
    };

     return this.http
        .post<any>('http://localhost/backend/v1/uac/type/update/(:num)', id, httpOptions)
        .pipe(
          map((user) => {
            return user;
          }),
        );
  };
  getRequestType = (id = 0) => {
    const httpOptions = {
      headers: new HttpHeaders({
        'Authorization': `Bearer `+localStorage.getItem('auth_token')
      }),
    };

    let url = 'http://localhost/backend/v1/uac/getType';
    if(id > 0) {
      url = 'http://localhost/backend/v1/uac/getType?id='+id;
    } 

    return this.http
      .get<any>(url, httpOptions)
      .pipe(
        map((userdata) => {
          return userdata;
        }),
      );
  };
  logout = () => {
    localStorage.removeItem('auth_token');
    localStorage.removeItem('user_code');
    this.router.navigate(['/']);
  }

  getAuthorizationToken = () => {
    return localStorage.auth_token;
  }
}
