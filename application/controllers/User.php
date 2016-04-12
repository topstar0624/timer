<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Timer_Model');
		$this->load->library('form_validation');
	}

	public function login()
	{
		$this->load->view('user/login');
	}

	public function login_validation()
	{
		$this->form_validation->set_rules('email', 'メールアドレス', 'required|trim|callback_validate_credentials');
		$this->form_validation->set_rules('pass', 'パスワード', 'required|trim');

		if($this->form_validation->run()) {
			//バリデーションエラーがなかった場合
			$data = array(
				'email' => $this->input->post('email'),
				'is_logged_in' => 1
			);
			$this->session->set_userdata($data);
			redirect('/user/members');
		} else {
			//バリデーションエラーがあった場合
			$this->load->view('user/login');
		}

	}

	//email情報がPOSTされたときに呼び出されるコールバック
	public function validate_credentials()
	{
		if($this->Timer_Model->can_login()) {
			//ユーザーがログインできた場合
			return true;
		} else {
			//ユーザーがログインできなかった場合
			$this->form_validation->set_message('validate_credentials', 'メールアドレスかパスワードが異なります');
			return false;
		}
	}

	public function members()
	{
		if($this->session->userdata('is_logged_in')) {
			//ログインしている場合
			$this->load->view('user/members');
		} else {
			//ログインしていない場合
			redirect('user/restricted');
		}
	}

	public function restricted()
	{
		$this->load->view('user/restricted');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('user/login');
	}
	
	public function signup()
	{
		$this->load->view('user/signup');
	}
	
	public function signup_validation()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user_table.email]');
		$this->form_validation->set_rules('pass', 'パスワード', 'required|trim');
		$this->form_validation->set_rules('confirm_pass', 'パスワード再入力', 'required|trim|matches[pass]');

		$this->form_validation->set_message('is_unique', '入力したメールアドレスはすでに登録されています。');
		$this->form_validation->set_message('matches', 'パスワードが一致しません。');

		if($this->form_validation->run()) {
			//バリデーションエラーがなかった場合

			//ランダムキーを生成
			$key=md5(uniqid(rand()));

			//メール送信
			$this->load->library('email');
			$this->email->from('no-reply@3910.club', 'サクッとタイマー事務局');
			$this->email->to($this->input->post('email'));
			$this->email->subject('【サクッとタイマー】仮登録が完了しました。');
			$this->email->message('
会員登録をしていただきありがとうございます。

こちらをクリックして、会員登録を完了してください。
'.base_url().'user/resister/'.$key.'
			');
			if($this->email->send()) {
				//メール送信が成功した場合
				$array = $_POST;
				$array['key'] = $key;
				$data['message'] = $this->Timer_Model->insert_array_model('temp_user_table', $array);
			} else {
				//メール送信が失敗した場合
				$data['message'] = '本登録メール送信失敗';
			}
			
		}else{
			//バリデーションエラーがあった場合
			//$this->load->view('user/signup');
			$data['message'] = 'バリデーションエラーがあったよ';
		}
		
		echo $data['message'];
	}
	
	public function resister($key){
		if($this->Timer_Model->is_valid_key($key)){
			//キーが正しい場合
			$array['key'] = $key;
			$data['message'] = $this->Timer_Model->insert_array_model('user_table', $array);
		} else {
			echo 'keyが間違ってるよ';
		}
	}
}