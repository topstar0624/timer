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
		$_SESSION['flash'] =  $this->Timer_Model->create_table_model($table_name);
		$this->session->mark_as_flash('flash');
		redirect('manage/');
	}

	function drop_table($table_name)
	{
		$_SESSION['flash'] =  $this->Timer_Model->drop_table_model($table_name);
		$this->session->mark_as_flash('flash');
		redirect('manage/');
	}
}
