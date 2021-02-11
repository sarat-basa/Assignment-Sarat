<?php

class Uac_model extends CI_Model
{

	/*************************************************
						Api model         
	**************************************************/
    public function getType($id=0) {
    	if($id>0) {
    		$sql = "SELECT id,req_type,req_desc,date(created_on) req_date,status, city, state, pin_code, country_code, phone_no,status,remark
                FROM request_list WHERE id = ?";
            $query = $this->db->query($sql,[$id]);
    	} else{
    		$sql = "SELECT id,req_type,req_desc,date(created_on) req_date,status
                FROM request_list";
            $query = $this->db->query($sql);
    	}
        return $query->result_array();
    }
    

}  