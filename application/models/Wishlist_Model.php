<?php
class Wishlist_Model extends CI_Model 
{
	public $table = 'wishlist';
	public $primary_key = 'id';

	public function read_first($id)
	{
		$db = $this->db;
		$db->select('*');
		$db->where($this->primary_key, $id);
		$db->limit(1);
		$rst = $db->get($this->table)->row();

		return $rst;
	}

	public function read_all($filters=array(), $limit=0, $offset=0)
	{
		$db = $this->db;
		$db->select('*');
		$db->where('deleted_at IS NULL', NULL, FALSE);

		if ( count($filters) > 0 )
		{
			foreach ( $filters as $key => $val )
			{
				$db->where($key, $val);	
			}	
		}

		if ( array_key_exists('id', $filters) )
		{
			// get single data
			$db->limit(1);
			$rst = $db->get($this->table)->row();
		}
		else
		{
			// get multiple data
			$db->order_by('updated_at', 'DESC');
			
			if ( (int)$limit > 0 && (int)$offset > 0 )
			{
				$db->limit($limit, $offset);	
			}
			else
			{
				$db->limit($limit);
			}

			$rst = $db->get($this->table)->result();
		}

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

	public function update_data($id, $data)
	{	
		$db = $this->db;
		$db->where($this->primary_key, $id);
		$db->update($this->table, $data);
		$rst = $db->affected_rows();
		
		return $rst;
	}
	
	public function delete_data($id, $deleted_by)
	{
		$data = array(
						'deleted_at' => getDateTime(),
						'deleted_by' => $deleted_by,
					);

		$db = $this->db;
		$db->where($this->primary_key, $id);
		$db->update($this->table, $data);
		$rst = $db->affected_rows();

		return $rst;
	}
}
?>