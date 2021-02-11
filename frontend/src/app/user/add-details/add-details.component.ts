import { Component, OnInit } from '@angular/core';
import { FormGroup, FormControl, Validators, FormBuilder, FormArray } from '@angular/forms';
import { ToastrService } from 'ngx-toastr';
import { AuthService } from "../../auth/auth.service";
import {Router} from '@angular/router';
@Component({
  selector: 'app-add-details',
  templateUrl: './add-details.component.html',
  styleUrls: ['./add-details.component.css']
})
export class AddDetailsComponent implements OnInit {

  _formData: FormGroup;

  constructor(
    private authService: AuthService,
    private toastr: ToastrService,
    private formBuilder: FormBuilder,
    private router: Router
  ) {
    this.setFormData();
  }

  ngOnInit(): void { }

  setFormData () {
    this._formData = this.formBuilder.group({
      reqType: this.formBuilder.array([], [Validators.required]),
      reqDesc: this.formBuilder.control('', [Validators.required]),
      city: this.formBuilder.control('', [Validators.required]),
      state: this.formBuilder.control('', [Validators.required]),
      pin_code: this.formBuilder.control('', [Validators.required,Validators.minLength(6),Validators.maxLength(6),Validators.pattern("^((\\+91-?)|0)?[0-9]{6}$")]),
      count_no : this.formBuilder.control('',[Validators.required]),
      phone_no : this.formBuilder.control('', [Validators.required,Validators.minLength(10),Validators.maxLength(10),Validators.pattern("^((\\+91-?)|0)?[0-9]{10}$")])
    })
  }

  onCheckboxChange(e) {
    const reqtype: FormArray = this._formData.get('reqType') as FormArray;
  
    if (e.target.checked) {
      reqtype.push(new FormControl(e.target.value));
    } else {
       const index = reqtype.controls.findIndex(x => x.value === e.target.value);
       reqtype.removeAt(index);
    }
  }

  submitData() {
    let formdata = {
      req_type: this._formData.value.reqType,
      req_desc: this._formData.value.reqDesc,
      city: this._formData.value.city,
      state: this._formData.value.state,
      pin_code: this._formData.value.pin_code,
      country_code: this._formData.value.count_no,
      phone_no: this._formData.value.phone_no,
    };
    //console.log(formdata);return;
    let url = 'http://localhost/backend/v1/uac/type/create';
    let method = 'post';

    this.authService.submitRequest(formdata, url, method).subscribe(
      (data) => {
        if (data.status) {
          this._formData.reset('');
          this.toastr.success('Request Created Successfully');
          this.router.navigate(['/user/dashboard']);
        } else {
          this.toastr.error('Failed to create request');
        }
      },
      (error) => this.toastr.error(error)
    );
  };

}
