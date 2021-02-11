import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { FormGroup, FormControl, Validators, FormBuilder, FormArray } from '@angular/forms';
import { ToastrService } from 'ngx-toastr';
import { AuthService } from "../../auth/auth.service";
import {Router} from '@angular/router';
@Component({
  selector: 'app-edit-data',
  templateUrl: './edit-data.component.html',
  styleUrls: ['./edit-data.component.css']
})
export class EditDataComponent implements OnInit {

  _formData: FormGroup;
  reqData: any = [];

  reqType: any;
  reqDesc: any;
  city: any;
  state: any;
  pinCode: any;
  countryCode: any;
  phoneNo: any;
  reqTypeList: string;
  status:string;
  remarks: string;
  editId: any;

  constructor(
    private route: ActivatedRoute,
    private authService: AuthService,
    private toastr: ToastrService,
    private formBuilder: FormBuilder,
    private router: Router
    
  ) { }

  ngOnInit(): void {
    let id = this.route.snapshot.params.id;
    this.getEditData(id);
  }

  getEditData(id) {
    this.authService.getRequestType(id).subscribe(
      (res) => {
        this.reqData= res.data;
        this.reqType = res.data[0].req_type;
        this.reqDesc = res.data[0].req_desc;
        this.city = res.data[0].city;
        this.state = res.data[0].state;
        this.countryCode = res.data[0].country_code;
        this.phoneNo = res.data[0].phone_no;
        this.pinCode = res.data[0].pin_code;
        this.reqTypeList = res.data[0].req_type_ar;
        this.editId = res.data[0].id;
        this.status = res.data[0].status;
        this.remarks = res.data[0].remark;
      }
    );
  }

  submitData () {
    let formdata = {
      status: this.status,
      remarks: this.remarks,
      id: this.editId
    };
    let url = 'http://localhost/backend/v1/uac/type/update';
    let method = 'post';

    this.authService.submitRequest(formdata, url, method).subscribe(
      (data) => {
        if (data.status) {
          this.toastr.success('Request Updated Successfully');
          this.router.navigate(['/user/dashboard']);
        } else {
          this.toastr.error('Failed to update request');
        }
      },
      (error) => this.toastr.error(error)
    );
  };


}
