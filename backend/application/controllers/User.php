<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Max-Age: 328600");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

class User extends MY_Controller
{
	public function __construct() {
		parent::__construct();
		$this->load->model('uac_model');
	}
	public function getType() {
		$headers = $this->input->request_headers();
		if(checkContentType($headers) && checkRequestMethod("GET")) {
			if ($res = $this->checkAuth($headers)) {
				$user_code = $res['user_code'];
				$get = $this->input->get();
				//print_r($get);exit;
				try {
					$temp = [];
					if (check_array($get)) {
						$data = $this->uac_model->getType($get['id']);
					} else{
						$data = $this->uac_model->getType();
					}
					if(isset($data) && is_array($data) && count($data) > 0) {
						$result = [];
						foreach ($data as $key => $value) {
							$req_type_ar = explode(',', $value['req_type']);
							$temp = [];
							for($i = 0; $i <  count($req_type_ar); $i++){
								if($req_type_ar[$i] == 1) {
									array_push($temp, "Plumbing");
								} 
								else if ($req_type_ar[$i] == 2) {
									array_push($temp, "Electrical");
								}
								else if ($req_type_ar[$i] == 3) {
									array_push($temp, "Painting");
								}
								else if ($req_type_ar[$i] == 4) {
									array_push($temp, "Deep Cleaning");
								}
							}
							$value['req_type_ar'] = implode(',', $temp);
							$result[] = $value;
						}
						response(200, true, "Request Lists", $result);
					}else{
						throwError(200, false, "No Request Found!");
					}
				} catch (Exception $e) {
					throwApiError(200, "Error: ". $e->getMessage());
				}	
			} else{
				throwApiError(200, "Access Denied");
			}
		}else{
			throwApiError(200, "Error: Invalid Request");
		}
	}
	//Creat Type method
	public function creatType() {
		$headers = $this->input->request_headers();
		if(checkContentType($headers) && checkRequestMethod("POST")) {
			if($res = $this->checkAuth($headers)) {
				$user_code = $res['user_code'];
				$post = json_decode($this->getRequest(), true);

				$req_type_ar = $post['req_type'];
				if(count($req_type_ar) == 0) {
					throwApiError(200, "Please select atleast one request type");
				} else{
					$req_type = implode(',', $req_type_ar);
				}

				$req_desc = validateParameter('Request Desc', $post['req_desc'], STRING);
				$city = validateParameter('City', $post['city'], STRING);
				$state = validateParameter('State', $post['state'], STRING);
				$pin_code = validateParameter('Pin Code', $post['pin_code'], STRING);
				$country_code = validateParameter('Country Code', $post['country_code'], STRING);
				$phone_no = validateParameter('Phone No', $post['phone_no'], STRING);
				
				$data['req_type'] = $req_type;
				$data['req_desc'] = $req_desc;
				$data['city'] = $city;
				$data['state'] = $state;
				$data['pin_code'] = $pin_code;
				$data['country_code'] = $country_code;
				$data['phone_no'] = $phone_no;
				$data['status'] = "PENDING";
				$data['created_on'] = date('Y-m-d H:i:s', time());
				$data['created_by'] = $user_code;
				try {
					$rs = $this->custom_db->insert_record('request_list', $data);
					if ($rs) {
						response(200, true, "Request List Created Successfully", $data);
					} else{
						throwApiError(200, "Insert Failed");
					}
				} catch (Exception $e) {
					throwApiError(200, "Error: ". $e->getMessage());
				}
			} else{
				throwApiError(200, "Access Denied");
			}
		}else{
			throwApiError(200, "Error: Invalid inputs");
		}
	}
	//Update Type
	public function updateType() {
		$headers = $this->input->request_headers();
		if(checkContentType($headers) && checkRequestMethod("POST")) {
			if($res = $this->checkAuth($headers)) {
				$user_code = $res['user_code'];
				$post = json_decode($this->getRequest(), true);
				$post = clean_array($post);
				//print_r($post);die;
				$id =  $post['id'];
				$status = validateParameter('Status', $post['status'], STRING);
				$remark = validateParameter('Remark', $post['remarks'], STRING);
				$data['status'] = $status;
				$data['remark'] = $remark;
				$data['updated_on'] = date('Y-m-d H:i:s', time());
				$data['updated_by'] = $user_code;
				try {
					$rs = $this->custom_db->update_record('request_list', $data, ['id' => $id]);
					if ($rs == true || $rs == 1) {
						response(200, true, "Request List Updated Successfully", $data);
					} else{
						throwApiError(200, "Failed to update data");
					}
				} catch (Exception $e) {
					throwApiError(200, "Error: ". $e->getMessage());
				}
			} else{
				throwApiError(200, "Access Denied");
			}
		}else{
			throwApiError(200, "Error: Invalid inputs");
		}
	}
}

?>