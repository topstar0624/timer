<?php

class Common_Model extends CI_Model
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
			if($this->dbforge->create_table($table_name)) {
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
			if($this->dbforge->drop_table($table_name)) {
				$message = $table_name.'の削除に成功しました';
			} else {
				$message = $table_name.'の削除に失敗しました';
			}
		} else {
			$message = $table_name.'は存在しません';
		}
		return $message;
	}
	
	function insert_model($table_name = '', $array = array())
	{
		$array['created'] = date('Y-m-d H:i:s');
		
		if($table_name === 'temp_user_table') {
			$insert_string = array(
				'key' => $array['key'],
				'email' => $_POST['email'],
				'pass' => $_POST['pass'],
				'created' => $array['created'],
			);
		} elseif ($table_name === 'user_table') {
			$this->db->where('key', $array['key']);
			$temp_user = $this->db->get('temp_user_table');
			if($temp_user){
				$row = $temp_user->row();
				$insert_string = array(
					'name' => substr($row->email, 0, strpos($row->email, '@')),
					'email' => $row->email,
					'pass' => $row->pass,
					'created' => $array['created'],
				);
			}
		} elseif ($table_name === 'task_table') {
			$insert_string = array(
				'user_id' => $_SESSION['user_id'],
				'title' => $array['title'],
				'time_limit' => $array['time_limit']?:0,
				'time_total' => $array['time_total'],
				'start' => $array['start'],
				'stop' => $array['stop'],
				'created' => $array['created'],
			);
		} else {
			return false;
		}
		$query = $this->db->insert_string($table_name, $insert_string);
		if($this->db->query($query)) {
			return true;
		} else {
			return false;
		}
	}
	
	function update_model($table_name = '', $array = array())
	{
		if($table_name === 'temp_user_table') {
			$update_string = array(
				'pass' => $_POST['pass'],
			);
			$where = array(
				'email' => $_POST['email'],
				'status' => 1,
			);
		} elseif ($table_name === 'user_table') {
		} elseif ($table_name === 'task_table') {
		} else {
			return false;
		}
		$query = $this->db->update_string($table_name, $update_string, $where);
		if($this->db->query($query)) {
			return true;
		} else {
			return false;
		}
	}
	
	public function delete_model($table_name = '', $array)
	{
		$array['deleted'] = date('Y-m-d H:i:s');
		
		if($table_name === 'temp_user_table') {
			$update_string = array(
				'deleted' => $array['deleted'],
				'status' => 0,
			);
			$this->db->where('key', $array['key']);
		}
		if($this->db->update($table_name, $update_string)) {
			return true;
		} else {
			return false;
		}
	}
}