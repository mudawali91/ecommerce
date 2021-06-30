<?php
class AccessLogs_Model extends CI_Model 
{
	public $table = 'access_logs';
	public $primary_key = 'id';

	public function read_current_log($id)
	{
		$db = $this->db;
		$db->select('id');
		$db->where('user_id', $id);
		$db->where('NOW() BETWEEN access_token_start AND access_token_expired');
		$db->where('deleted_at IS NULL', NULL, FALSE);
		$db->limit(1);
		$rst = $db->get($this->table)->row();

		return $rst;
	}

	public function create_data($data)
	{
		$db = $this->db;
		$db->insert($this->table, $data);
		$rst = $db->insert_id();

		return $rst;
	}

	public function create_data_multiple($data)
	{
		$db = $this->db;
		$rst = $db->insert_batch($this->table, $data);

		return $rst;
	}
}
?>