<?php

//check for request content type
function checkContentType($headers) {
	#echo json_encode($headers);exit;
	/*if($headers['Content-Type'] === 'application/json'){
		return true;
	}*/
	return true;
}

//check request method
function checkRequestMethod($method) {
	//echo $method;exit;
	if($_SERVER['REQUEST_METHOD'] === $method) {
		return true;
	}else{
		throwError(200, false, "Request Method is Not Valid");
	}
}


//validate parameters
function validateParameter($fieldName, $value, $dataType, $required = true) {
	if($required == true && empty($value) == true){
		throwError(200, false, $fieldName." is required");
	}

	switch ($dataType) {
		case BOOLEAN:
			if(!is_bool($value)) {
				throwError(200, false, 'Datatype is not valid for ' . $fieldName . '. It should be boolean.');
			}
			break;
		case INTEGER:
			if(!is_numeric($value)) {
				throwError(200, false, 'Datatype is not valid for ' . $fieldName . '. It should be numeric.');
			}
			break;
		case STRING:
			if(!is_string($value)) {
				throwError(200, false, 'Datatype is not valid for ' . $fieldName . '. It should be string.');
			}
			break;
		
		default:
		 	throwError(200, false, 'Datatype is not valid for ' . $fieldName);
			break;
	}

	return $value;
}

//check for valid array
function check_array($ar=""){
    if(is_array($ar) && count($ar)>0){
        return true;
    } else {
        return false;
    }
}

//debug method
function debug_array($ar=array(),$stat=true){
    echo "<pre>",print_r($ar);
    if($stat){
        exit;
    }
}

//check for array element
function check_array_element($ar=array(),$el=array()){
    $stat=false;
    $chk=0;
    if(check_array($ar)){
        foreach ($ar as $k => $v) {
            foreach ($el as $k0 => $v0) {
                if($k==$v0){
                    $chk++;
                }
            }
        }
        if($chk!=count($el)){
            $stat=false;
        } else {
            $stat=true;
        }
    }

    return $stat;
}

//clean xss elements and trim psaces
function clean_array($ar=array()){ 
    if(check_array($ar)){
        foreach ($ar as $k => $v) {
            $ar[$k]=clean_ele($v);
        }
    }
    return $ar;
}

//clean array element
function clean_ele($el=''){
    return strip_tags(trim($el));
}

//email helper
function emailTemplate($body) {

	/*$body = '<p style="font-weight: 600;font-size: 16px;">Dear Gajanan,</p>
			<p style="font-size: 14px;margin-top: 40px">Thank you for registering with Mentified.com. You can continue you usage with the app very smoothly</p>
			<p style="font-size: 14px;">
				<a href="http://google.co.in" target="_blank" style="text-decoration: none;">Reset Password</a>
			</p>';*/
	$html = '';
	$html .= '<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Email Template</title>
</head>
<body style="margin:0;padding:0;font-family: "Helvetica", sans-serif">
	<table style="border:0;width:80%;margin:0 auto;height: auto;background: #f5f7f8">
		<tr>
			<td>
				<header style="height: auto;width: 100%;padding:30px 0;border-bottom: 1px solid #222">
					<div style="text-align:center">
						<img src="https://image.shutterstock.com/z/stock-vector-user-icon-in-trendy-flat-style-isolated-on-grey-background-user-symbol-for-your-web-site-design-418179856.jpg" height="100px" width="100px">
						<h2 style="padding:0;margin:10px 0;text-transform: uppercase;">Welcome to Mentified</h2>
					</div>
				</header>
			</td>
		</tr>
		<tr>
			<td style="padding:10px 20px">'.$body.'<p style="font-size: 17px;font-weight: 600;margin-top: 100px;">Thanks</p>
			<p>Mentified Team</p>
			<p><a href="https://mentified.com" target="_blank" style="text-decoration: none;">http://mentified.com</a></p>
			</td>
		</tr>
		<tr style="background: #815c9e">
			<td style="padding:10px;color: #fff;text-align: center;">
				<h2 style="padding-bottom: 0px">Follow Us On</h2>
				<ul style="margin:0;padding:0;list-style: none">
					<li style="display:inline-block;padding:0 10px;border-right: 1px solid #eee"><a style="text-decoration: none;color: #fff" href="https://facebook.com/mentified">Facebook</a></li>
					<li style="display:inline-block;padding:0 10px;border-right: 1px solid #eee"><a style="text-decoration: none;color: #fff" href="https://twitter.com/mentified">Twitter</a></li>
					<li style="display:inline-block;padding:0 10px"><a style="text-decoration: none;color: #fff" href="https://linkedin.com/mentified">Linked in</a></li>
				</ul>
				<p style="line-height: 30px;letter-spacing: 1px;padding-top: 20px">Need help? If you have any questions, please feel free to contact us at info@mentified.com<br/>
				If you have not registered on Mentified, please ignore this email.</p>
			</td>
		</tr>
	</table>
</body>
</html>';

return $html;

}

//generate referral code
function generateReferral($no = 6) {
	$chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
	$res = "";
	for($i = 0; $i < $no; $i++){
		$res .= $chars[mt_rand(0, strlen($chars)-1)];
	}

	return $res;
}

function getGUID(){
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtolower(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
        return $uuid;
    }
}
//
//throw error response
function throwError($response_code, $status, $message) {
	http_response_code($response_code);
	$error_response = json_encode(['status' => $status, 'message' => $message]);
	echo $error_response; exit;
}
function throwApiError($response_code, $message) {
	http_response_code($response_code);
	$error_response = json_encode(['message' => $message]);
	echo $error_response; exit;
}

// return response to client
function response($response_code, $status, $message, $data = null) {
	http_response_code($response_code);
	$response = json_encode(['status' => $status, 'message' => $message, 'data' => $data]);
	echo $response; exit;
}
