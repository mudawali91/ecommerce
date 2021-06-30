<?php
class User_Model extends CI_Model 
{
	public $table = 'user';
	public $primary_key = 'id';

	public function read_first($id)
	{
		$db = $this->db;
		$db->select('id, type, username, first_name, last_name, email, created_at, updated_at');
		$db->where($this->primary_key, $id);
		$db->where('deleted_at IS NULL', NULL, FALSE);
		$db->limit(1);
		$rst = $db->get($this->table)->row();

		return $rst;
	}

	public function read_login($username, $password, $type)
	{
		$db = $this->db;
		$db->select('id, type, username, first_name, last_name, email, created_at, updated_at');
		$db->where('deleted_at IS NULL', NULL, FALSE);
		$db->where('username', $username);
		$db->where('password', encryptor('encrypt', $password));
		$db->where_in('type', $type);
		$db->limit(1);
		$rst = $db->get($this->table)->row();

		return $rst;
	}
}
?>