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
		$this->form_validation->set_rules('email', 'メールアドレス', 'required|trim|callback_can_login');
		$this->form_validation->set_rules('pass', 'パスワード', 'required|trim');

		if($this->form_validation->run()) {
			//バリデーションエラーがなかった場合
			$_SESSION = array(
				'email' => $this->input->post('email'),
				'is_login' => 1,
			);
			$_SESSION['flash'] = 'ログインしました';
			$this->session->mark_as_flash('flash');
			redirect('/');
		} else {
			//バリデーションエラーがあった場合
			$this->load->view('user/login');
		}
	}

	//email情報がPOSTされたときに呼び出されるコールバック
	public function can_login()
	{
		if($this->Timer_Model->is_user()) {
			//ユーザーが存在した場合
			return true;
		} else {
			//ユーザーが存在しなかった場合
			$this->form_validation->set_message('can_login', 'メールアドレスかパスワードが異なります');
			return false;
		}
	}
	
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('user/login');
	}
	
	public function signup()
	{
		$data['message'] = '';
		$this->load->view('user/signup', $data);
	}
	
	public function signup_validation()
	{
		$data['message'] = '';
		
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user_table.email]');
		$this->form_validation->set_rules('pass', 'パスワード', 'required|trim');
		$this->form_validation->set_rules('confirm_pass', 'パスワード再入力', 'required|trim|matches[pass]');
		
		$this->form_validation->set_message('is_unique', 'このメールアドレスでは登録できません。');
		$this->form_validation->set_message('matches', 'パスワードが一致しません。');

		if($this->form_validation->run()) {
			//バリデーションエラーがなかった場合
			$key = md5(uniqid(rand()));
			$this->load->library('email');
			$this->email->to($this->input->post('email'));
			$this->email->from('no-reply@3910.club', 'サクッとタイマー事務局');
			$this->email->bcc('no-reply@3910.club');
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
				//$data['email'] = $_POST['email'];
				$this->load->view('user/temporary', $data);
			
			} else {
				//メール送信が失敗した場合
				$data['message'] = '本登録メール送信失敗';
				$this->load->view('user/signup', $data);
			}
			
		}else{
			//バリデーションエラーがあった場合
			$this->load->view('user/signup', $data);
			//redirect('user/signup');
		}
	}
	
	public function resister($key){
		if($this->Timer_Model->is_valid_key($key)){
			//キーが正しい場合
			$array['key'] = $key;
			$data['message'] = $this->Timer_Model->insert_array_model('user_table', $array);
			$_SESSION = array(
				'is_login' => 1,
			);
			$this->load->view('user/register', $data);
		} else {
			echo 'keyが間違ってるよ';
		}
	}
}