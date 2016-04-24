<?php

class Temp_User_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->dbforge();
		date_default_timezone_set('Asia/Tokyo');
	}

	public function is_email()
	{
		$this->db->where(array(
			'email' => $_POST['email'],
			'status' => 1,
		));
		$query = $this->db->get('temp_user_table');
		if($query->num_rows() == 1){
			return true;
		}else{
			return false;
		}
	}
	
	public function is_key($key){
		$this->db->where(array(
			'key' => $key,
			'status' => 1,
		));
		$query = $this->db->get('temp_user_table');
		if($query->num_rows() == 1){
			return true;
		} else {
			return false;
		}
	}
	
	public function get_key(){
		$this->db->where(array(
			'email' => $_POST['email'],
			'status' => 1,
		));
		$query = $this->db->get('temp_user_table');
		return $query->row()->key;
	}
}