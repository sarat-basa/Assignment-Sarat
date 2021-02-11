<?php
Class Custom_Db extends CI_Model{
	
	function get_records($table, $condition = '', $cols='*')
	{
		$data = '';
		$temp_condition = array('1' => 1);
		if (strlen($table) > 0 ) {
			if(is_array($condition)) {
				$temp_condition = $condition; 
			}
			$tmp_data = $this->db->select($cols)->get_where($table, $temp_condition)->result_array();
			$data = array('status' => 1, 'data' => $tmp_data);
		} else {
			redirect('login/logout');
		}
		//echo  $this->db->last_query();exit;
		return $data;
	}
	
	/*
	* Selecting rows from table without condition
	* $table is Table name
	*/
	function fetch_records ($table, $cols='*', $order='')
	{
            $data = '';
            if (strlen($table) > 0 ) {
                if ($order != '') {
                    if (valid_array($order) == true) {
                        foreach ($order as $o_k => $o_v) {
                            $this->db->order_by($o_k, $o_v);
                        }
                    }
                }
                $tmp_data = $this->db->select($cols)->get_where($table)->result_array();
                $data = array('status' => 1, 'data' => $tmp_data);
            } else {
                redirect('login/logout');
            }
            return $data;
	}
	
	/*
	*this will insert the data into database and create new record
	*
	*@param string $table_name name of the table to which the data has to be inserted
	*@param array  $data       data which has to be inserted into database
	*
	*@return array has status of insertion and insert id
	*/
	function insert_record ($table_name, $data)
	{
		$insert = $this->db->insert($table_name, $data);
		
		$num_inserts = $this->db->affected_rows();
		//print_r($this);
		if (intval($num_inserts) > 0) {
			$data = array('status' => 1, 'insert_id' => $this->db->insert_id());
		} else {
			redirect('login/logout');
		}
		return $data;
	}
	
	
	/*
	*this will insert the data into database and update existing record
	*
	*@param string $table_name name of the table to which the data has to be inserted
	*@param array  $data       data which has to be inserted into database
	*
	*@return array has status of insertion and insert id
	*/
	function update_record ($table_name='', $data='', $condition='')
	{
		$status = '';
		if (strlen($table_name) > 1 and is_array($data) == true and is_array($condition)) {
			$this->db->trans_start();
			$this->db->update($table_name, $data, $condition);
			
			$this->db->trans_complete();
			$status = 1;
		} else {
			//redirect('login/logout');
			$status = 0;
		}
		return $status;
	}
}

?>
