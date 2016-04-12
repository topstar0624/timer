<?php

class Timer_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->dbforge();
		date_default_timezone_set('Asia/Tokyo');
	}

	function create_table_model($table_name = '')
	{
		if(!$this->db->table_exists($table_name)) {
			if($table_name === 'temp_user_table') {
				$this->dbforge->add_field(
					array(
						'id' => array(
							'type' => 'INT',
							'constraint' => 9,
							'unsigned' => TRUE,
							'auto_increment' => TRUE,
						),
						'key' => array(
							'type' => 'VARCHAR',
							'constraint' => 255,
						),
						'email' => array(
							'type' => 'VARCHAR',
							'constraint' => 255,
						),
						'pass' => array(
							'type' => 'VARCHAR',
							'constraint' => 255,
						),
						'created' => array(
							'type' => 'DATETIME',
						),
						'modified' => array(
							'type' =>'TIMESTAMP',
						),
						'deleted' => array(
							'type' =>'DATETIME',
						),
						'status' => array(
							'type' => 'INT',
							'constraint' => 1,
							'unsigned' => TRUE,
							'default' => 1,
						),
						'memo' => array(
							'type' => 'TEXT',
							'null' => TRUE,
						),
					)
				);
			} elseif ($table_name === 'user_table') {
				$this->dbforge->add_field(
					array(
						'id' => array(
							'type' => 'INT',
							'constraint' => 9,
							'unsigned' => TRUE,
							'auto_increment' => TRUE,
						),
						'name' => array(
							'type' => 'VARCHAR',
							'constraint' => 255,
						),
						'email' => array(
							'type' => 'VARCHAR',
							'constraint' => 255,
						),
						'pass' => array(
							'type' => 'VARCHAR',
							'constraint' => 255,
						),
						'created' => array(
							'type' => 'DATETIME',
						),
						'modified' => array(
							'type' =>'TIMESTAMP',
						),
						'deleted' => array(
							'type' =>'DATETIME',
						),
						'status' => array(
							'type' => 'INT',
							'constraint' => 1,
							'unsigned' => TRUE,
							'default' => 1,
						),
						'memo' => array(
							'type' => 'TEXT',
							'null' => TRUE,
						),
					)
				);
			} elseif ($table_name === 'task_table') {
				$this->dbforge->add_field(
					array(
						'id' => array(
							'type' => 'INT',
							'constraint' => 9,
							'unsigned' => TRUE,
							'auto_increment' => TRUE,
						),
						'user_id' => array(
							'type' => 'INT',
							'constraint' => 9,
							'unsigned' => TRUE,
						),
						'title' => array(
							'type' => 'VARCHAR',
							'constraint' => 255,
						),
						'time_limit' => array(
							'type' => 'INT',
							'constraint' => 4,
							'unsigned' => TRUE,
							'null' => TRUE,
						),
						'time_total' => array(
							'type' => 'INT',
							'constraint' => 4,
							'unsigned' => TRUE,
							'null' => TRUE,
						),
						'start' => array(
							'type' => 'DATETIME',
						),
						'stop' => array(
							'type' => 'DATETIME',
						),
						'created' => array(
							'type' => 'DATETIME',
						),
						'modified' => array(
							'type' =>'TIMESTAMP',
						),
						'deleted' => array(
							'type' => 'DATETIME',
						),
						'status' => array(
							'type' => 'INT',
							'constraint' => 1,
							'unsigned' => TRUE,
							'default' => 1,
						),
						'memo' => array(
							'type' => 'TEXT',
							'null' => TRUE,
						),
					)
				);
			} else {
				$message = $table_name?$table_name.'は':'';
				$message =+ '定義されていません';
				return $message;
			}
			$this->dbforge->add_key('id', TRUE);
			$flag = $this->dbforge->create_table($table_name);
			if($flag) {
				$message = $table_name.'の作成に成功しました';
			} else {
				$message = $table_name.'の作成に失敗しました';
			}
		} else {
			$message = $table_name.'はすでに存在します';
		}
		return $message;
	}

	function drop_table_model($table_name)
	{
		if($this->db->table_exists($table_name)) {
			$flag = $this->dbforge->drop_table($table_name);
			if($flag) {
				$message = $table_name.'の削除に成功しました';
			} else {
				$message = $table_name.'の削除に失敗しました';
			}
		} else {
			$message = $table_name.'は存在しません';
		}
		return $message;
	}

	function insert_array_model($table_name = '', $array)
	{
		$array['created'] = date('Y-m-d H:i:s');
		
		if($table_name === 'temp_user_table') {
			$insert_string = array(
				'key' => $array['key'],
				'email' => $array['email'],
				'pass' => $array['pass'],
				'created' => $array['created'],
			);
		} elseif ($table_name === 'task_table') {
			$insert_string = array(
				'user_id' => 1,
				'title' => $array['title'],
				'time_limit' => $array['time_limit']?:0,
				'time_total' => $array['time_total'],
				'start' => $array['start'],
				'stop' => $array['stop'],
				'created' => $array['created'],
			);
		} else {
			$message = $table_name?$table_name.'は':'';
			$message =+ '定義されていません';
			return $message;
		}
		$query = $this->db->insert_string($table_name, $insert_string);
		$flag = $this->db->query($query);
		if($flag) {
			$message = $table_name.'への挿入に成功しました';
		} else {
			$message = $table_name.'の挿入に失敗しました';
		}
		return $message;
	}

	public function can_login()
	{
		$this->db->where('email', $this->input->post('email')); //POSTされたemailデータとDB情報を照合する
		$this->db->where('pass', $this->input->post('pass')); //POSTされたパスワードデータとDB情報を照合する
		$query = $this->db->get('user_table');

		if($query->num_rows() == 1){
			//ユーザーが存在した場合
			return true;
		}else{
			//ユーザーが存在しなかった場合
			return false;
		}
	}
}