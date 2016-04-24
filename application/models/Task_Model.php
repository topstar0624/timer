<?php

class Task_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->dbforge();
		date_default_timezone_set('Asia/Tokyo');
	}

	public function get_tasks(){
		$this->db->where(array(
			'user_id' => $_SESSION['user_id'],
			'status' => 1,
		));
		$query = $this->db->get('task_table');
		
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
}