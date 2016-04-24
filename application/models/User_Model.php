<?php

class User_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->dbforge();
		date_default_timezone_set('Asia/Tokyo');
	}

	public function is_user()
	{
		$this->db->where(array(
			'email' => $_POST['email'],
			'pass' => $_POST['pass'],
			'status' => 1,
		));
		$query = $this->db->get('user_table');
		if($query->num_rows() == 1){
			return true;
		}else{
			return false;
		}
	}
	
	public function get_user_id(){
		$this->db->where(array(
			'email' => $_POST['email'],
			'status' => 1,
		));
		$query = $this->db->get('user_table');
		return $query->row()->id;
	}
}