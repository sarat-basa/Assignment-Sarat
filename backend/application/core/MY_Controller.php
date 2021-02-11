<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//includes required libraries
require_once APPPATH . 'libraries/JWT.php';
require_once APPPATH . 'libraries/BeforeValidException.php';
require_once APPPATH . 'libraries/ExpiredException.php';
require_once APPPATH . 'libraries/SignatureInvalidException.php';

use \Firebase\JWT\JWT;

class MY_Controller extends CI_Controller
{
	
	public function __construct() {
		parent::__construct();
	}

	//get input request method from client
	public function getRequest() {
		if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
	        response(200, true, "API Ok");
		}else{
			$req = json_decode(file_get_contents('php://input'), true);

			if(isset($req) && is_array($req) && count($req) > 0) {
				$req = $req;
			} else{
				$req = $this->input->raw_input_stream;
			}
			#echo '<pre>'; print_r($req);exit;
			if(is_array($req)){
				$req = $req;
			}else{
				parse_str($req, $jsonStr);
				$req = $jsonStr;
			}
			return json_encode($req);
		}
	}

	//check authentication method
	public function checkAuth($headers) {
		if(isset($headers) && is_array($headers) && count($headers) > 0) {
			$token = "";
			if(isset($headers['Authorization'])){
				$auth_token_ar = explode(' ', $headers['Authorization']);
				//$token  = $headers['Authorization'];
				$token  = $auth_token_ar[1];
				$auth_type = $auth_token_ar[0];
				if ($auth_type == 'Bearer') {
					if($token) {
						try {
							$decoded_token = JWT::decode($token, KEY, array('HS256'));
							$user_code = $decoded_token->data->user_code;
							#print_r($user_code);die;
							$t = $this->custom_db->get_records("user_token", ['user_code' => $user_code], 'user_code, token');
							$result = $t['data'];
							if(isset($result) && is_array($result) && count($result) > 0) {
								$response['status'] = true;
								$response['user_code'] = $result[0]['user_code'];
								return $response;
							}else{
								return false;
							}
						} catch (Exception $e) {
							return false;
						}
					}else{
						return false;
					}
				} else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	
	protected function get_key() {
		return "0123456789abcdef0123456789abcdef";
	}
	protected function get_iv() {
		return "abcdef9876543210abcdef9876543210";
	}
}