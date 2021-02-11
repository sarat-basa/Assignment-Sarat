<?php

class Auth_model extends CI_Model
{
	
	public function __construct(){
		parent::__construct();
	}
	/*************************************************
						Api model         
	**************************************************/
	public function uscLogin($email_id) {
		$sql = $this->db->select('*')
                        ->from('user_master')
                        ->where('email_id', $email_id)
                        ->get();
        #echo  $this->db->last_query();exit;
        return $sql->row_array();
	}

}