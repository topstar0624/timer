<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('Common_Model');
		$this->load->model('User_Model');
		$this->load->model('Temp_User_Model');
		$this->load->library('form_validation');
		$this->load->library('email');
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
			$user_id = $this->User_Model->get_user_id();
			$_SESSION = array(
				'user_id' => $user_id,
				'login' => 1,
				'flash' => 'ログインしました',
			);
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
		if($this->User_Model->is_user()) {
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
		unset(
			$_SESSION['user_id'],
			$_SESSION['login']
		);
		$_SESSION['flash'] = 'ログアウトしました';
		$this->session->mark_as_flash('flash');
		redirect('/');
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

		$this->form_validation->set_message('is_unique', 'このメールアドレスでは登録できません。');
		$this->form_validation->set_message('matches', 'パスワードが一致しません。');

		if($this->form_validation->run()) {
			//バリデーションエラーがなかった場合
			
			if($this->Temp_User_Model->is_email()) {
				//temp_user_tableにすでにメアドの登録があった場合
				$this->Common_Model->update_model('temp_user_table'); //パスワードを更新
				$key = $this->Temp_User_Model->get_key(); //keyを取得
			} else {
				//temp_user_tableにまだメアドの登録がなかった場合
				$key = md5(uniqid(rand())); //keyを生成
				$array['key'] = $key;
				$this->Common_Model->insert_model('temp_user_table', $array);
			}
			
			//メール送信設定
			$this->email->to($_POST['email']);
			$this->email->from('no-reply@3910.club', 'サクッとタイマー事務局');
			$this->email->bcc('no-reply@3910.club');
			$this->email->subject('【サクッとタイマー】仮登録が完了しました。');
			$this->email->message('
会員登録をしていただきありがとうございます。

こちらをクリックして、会員登録を完了してください。
{unwrap}'.base_url().'user/resister/'.$key.'{/unwrap}
			');
			
			if($this->email->send()) {
				//メール送信が成功した場合
				$this->load->view('user/temporary');
			} else {
				//メール送信が失敗した場合
				$data['message'] = '登録確認メールの送信が失敗しました。';
				$this->load->view('user/signup', $data);
			}
		
		}else{
			//バリデーションエラーがあった場合
			$this->load->view('user/signup');
		}
	}
	
	public function resister($key){
		if($this->Temp_User_Model->is_key($key)){
			//キーが正しい場合
			$array['key'] = $key;
			$this->Common_Model->delete_model('temp_user_table', $array);
			$user_id = $this->Common_Model->insert_model('user_table', $array);
			$_SESSION = array(
				'user_id' => $user_id,
				'login' => 1,
			);
			$this->load->view('user/register');
		} else {
			//キーが正しくない場合
			$data['message'] ='本登録用URLの有効期限が切れているか、無効になっています。お手数をお掛けしますが、再度会員登録からお願いします。';
			$this->load->view('user/signup', $data);
		}
	}
}