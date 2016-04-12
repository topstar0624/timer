<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Timer_Model');
	}

	public function index()
	{
		$data['message'] = '';
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			if($this->session->userdata('ticket') === $_POST['ticket']) { //リロード対策
				$this->session->unset_userdata('ticket');
				$data['message'] = $this->Timer_Model->insert_array_model('task_table', $_POST);
			}
		}

		//モバイル判定
		//参考）https://syncer.jp/how-to-use-mobile-detect
		$data['mobile'] = false;
		require_once 'Mobile_Detect.php' ;
		$detect = new Mobile_Detect ;
		if($detect->isTablet() || $detect->isMobile()) {
			$data['mobile'] = true;
		}

		$this->load->view('main/index', $data);
	}
	
	public function timer()
	{
		$data['ticket'] = md5(uniqid(rand()));
		$this->session->set_userdata('ticket', $data['ticket']);
		/*$this->input->set_cookie(array(
			'name' => 'ticket',
			'value' => $data['ticket'],
		));*/
		$this->load->view('main/timer', $data);
	}
}