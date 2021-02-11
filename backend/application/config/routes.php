<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';

$route['v1/auth/login'] = 'auth/login';
$route['v1/auth/signup'] = 'auth/signup';

$route['v1/uac/getType'] = 'user/getType'; 
$route['v1/uac/type/create'] = 'user/creatType';
$route['v1/uac/type/update'] = 'user/updateType';
