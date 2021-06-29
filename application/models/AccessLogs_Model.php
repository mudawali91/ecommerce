<?php
class AccessLogs_Model extends CI_Model 
{
	public $table = 'access_logs';
	public $primary_key = 'id';

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