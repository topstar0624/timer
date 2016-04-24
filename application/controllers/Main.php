<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Common_Model');
		$this->load->model('Task_Model');
	}

	public function index()
	{
		//モバイル判定
		//参考）https://syncer.jp/how-to-use-mobile-detect
		$data['mobile'] = false;
		require_once 'Mobile_Detect.php' ;
		$detect = new Mobile_Detect ;
		if($detect->isTablet() || $detect->isMobile()) {
			$data['mobile'] = true;
		}
		
		if(isset($_SESSION['login']) && isset($_SESSION['user_id'])) {
			$data['tasks'] = $this->Task_Model->get_tasks();
		}
		
		$this->load->view('main/index', $data);
	}
	
	public function timer()
	{
		$data['ticket'] = md5(uniqid(rand())); //リロード対策
		$_SESSION['ticket'] = $data['ticket']; //リロード対策
		$this->load->view('main/timer', $data);
	}
	
	public function timer_post()
	{
		if($_SESSION['ticket'] === $_POST['ticket']) { //リロード対策
			unset($_SESSION['ticket']);
			if($this->Common_Model->insert_model('task_table', $_POST)) {
				$_SESSION['flash'] = 'タスクを記録しました。';
			} else {
				$_SESSION['flash'] = 'タスクの記録に失敗しました。';
			}
			$this->session->mark_as_flash('flash');
		}
		redirect('/');
	}
}