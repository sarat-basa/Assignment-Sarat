<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Kolkata');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 328600");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//includes required libraries
require_once APPPATH . 'libraries/JWT.php';
require_once APPPATH . 'libraries/BeforeValidException.php';
require_once APPPATH . 'libraries/ExpiredException.php';
require_once APPPATH . 'libraries/SignatureInvalidException.php';

use \Firebase\JWT\JWT;

class Auth extends MY_Controller
{
	
	public function __construct() {
		parent::__construct();
		$this->load->model('Auth_model');
	}
	
	//all registered users
	public function signup() {
		
		$headers = $this->input->request_headers();
		if(checkContentType($headers) && checkRequestMethod("POST")) {
			$post =  json_decode($this->getRequest(), true);
		   
		   	$key = hex2bin($this->get_key());
			$iv =  hex2bin($this->get_iv());
			
			$email_id = validateParameter('Username', strip_tags(trim($post['email_id'])), STRING);
			$enc_pass = validateParameter('Password', strip_tags(trim($post['password'])), STRING);
			$options = [
					'cost' => 11,
				];
			$password = password_hash($enc_pass, PASSWORD_BCRYPT, $options);
			//print_r($password);die;
			try {
				
				$result  = $this->Auth_model->uscLogin($email_id);
				$user_code=time().mt_rand(100, 999);
				if ($result=="") {
					$data = array(
						"user_code" => $user_code,
						"email_id" => $email_id,
						"password" => $password,
						"created_on" => date('Y-m-d H:i:s', time()),
						"record_status" => 1
					);
					$insert = $this->db->insert('user_master', $data);
					//echo $this->db->last_query();die;
					if($insert){
						response(200, true, "Register Successfully");
					}else{
						$dbstatus = false;
						$dbmessage = 'Error While Saving';
					}
				} 
				else{
						throwApiError(200, "User Exist");
					}

			} catch (Exception $e) {
				throwApiError(200, "Error: ". $e->getMessage());
			}
		}else{
			throwApiError(200, "Error: Invalid content type");
		}
	}
	//Login method
	public function login() {
		$headers = $this->input->request_headers();
		if(checkContentType($headers) && checkRequestMethod("POST")) {
			$post =  json_decode($this->getRequest(), true);
			#echo '<pre>'; print_r($post);exit;
			$key = hex2bin($this->get_key());
			$iv =  hex2bin($this->get_iv());
			$enc_pass = $post['password'];
			$str_pass = openssl_decrypt($enc_pass, 'AES-128-CBC', $key, OPENSSL_ZERO_PADDING, $iv);
			$email = validateParameter('Email', strip_tags(trim($post['email_id'])), STRING);
			$password = validateParameter('Password', strip_tags(trim($enc_pass)), STRING);
			try {
				
				$result  = $this->Auth_model->uscLogin($email);
				if (isset($result) && is_array($result) && count($result) > 0) {
				    if (password_verify($password, $result['password'])) {	
						$token = [
							"iss" => ISS,
							"aud" => AUD,
							"iat" => IAT,
							"data" => [
								"user_code" => $result['user_code'],
								"email_id" => $result['email_id']
							]
						];
						//encode generated JWt
						$jwt = JWT::encode($token, KEY);
						$tokenInfo['user_code'] = $result['user_code'];
						$tokenInfo['token'] = $jwt;
						$tokenInfo['record_status'] = 1;
						$tokenInfo['created_on'] = date('Y-m-d H:i:s', time());
						//print_r($tokenInfo);
						$rs = $this->custom_db->insert_record('user_token', $tokenInfo);
						//print_r($rs);die;
						if (isset($rs) && $rs['insert_id'] > 0) {
							$res['token'] = $jwt;
							$res['user_code'] = $result['user_code'];
							response(200, true, "you have succesfully login", $res);
						}
						else{
							throwApiError(200, "Failed to login, try again");
						}
					} else{
						throwApiError(200, "Invalid password");
					}
				} else{
					throwApiError(200, "Invalid username");
				}

			} catch (Exception $e) {
				throwApiError(200, "Error: ". $e->getMessage());
			}
		}else{
			throwApiError(200, "Error: Invalid content type");
		}
	}
	
}
