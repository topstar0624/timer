<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Timer_Model');
	}

	function index()
	{
		$this->load->view('manage/index');
	}

	function create_table($table_name)
	{
		echo $this->Timer_Model->create_table_model($table_name);
	}

	function drop_table($table_name)
	{
		echo $this->Timer_Model->drop_table_model($table_name);
	}
}
