<?php
class WishlistItem_Model extends CI_Model 
{
	public $table = 'wishlist_item';
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

	public function read_all($filters=array())
	{
		$db = $this->db;
		$db->select('a.id, a.wishlist_id, a.color, a.size, a.remark, a.product_id, b.sku AS product_sku, b.name AS product_name, b.product_brand_id, c.description AS product_brand, b.product_category_id, d.description AS product_category, CONCAT(\''.base_url().PRODUCT_PATH.'\', e.image) AS product_image');
		$db->from($this->table.' a');
		$db->join('product b', 'b.id = a.product_id', 'LEFT');
		$db->join('product_brand c', 'c.id = b.product_brand_id', 'LEFT');
		$db->join('product_category d', 'd.id = b.product_category_id', 'LEFT');
		$db->join('product_color e', 'e.product_id = a.product_id AND e.color = a.color', 'LEFT');
		$db->where('a.deleted_at IS NULL', NULL, FALSE);

		if ( count($filters) > 0 )
		{
			foreach ( $filters as $key => $val )
			{
				if ( is_array($val) && count($val) > 0 )
				{
					$db->where_in($key, $val);	
				}
				else
				{
					$db->where($key, $val);	
				}	
			}	
		}
		
		$db->order_by('a.updated_at', 'DESC');
		$rst = $db->get()->result();

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
	
	public function delete_data_multiple($filters=array(), $deleted_by)
	{
		$data = array(
						'deleted_at' => getDateTime(),
						'deleted_by' => $deleted_by,
					);

		$db = $this->db;
		$rst = 0;

		if ( isset($filters['id']) || isset($filters['wishlist_id']) )
		{
			if ( count($filters) > 0 )
			{
				foreach ( $filters as $key => $val )
				{
					if ( is_array($val) && count($val) > 0 )
					{
						$db->where_in($key, $val);	
					}
					else
					{
						$db->where($key, $val);	
					}	
				}
			}

			$db->update($this->table, $data);
			$rst = $db->affected_rows();
		}

		return $rst;
	}
}
?>