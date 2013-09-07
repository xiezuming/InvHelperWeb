<?php
Class Inv_item_model extends CI_Model
{
	const TABLE_ITEM = 'inv_item';

	public function add_inv_item($data)
	{
		$where = array('userId' => $data['userId'],
				'itemId' => $data['itemId']);

		$query = $this->db->get_where(self::TABLE_ITEM, $where);
		if ( $query->num_rows() > 0) {
			$this->db->delete(self::TABLE_ITEM, $where);
		}

		return $this->db->insert(self::TABLE_ITEM, $data);
	}

}
?>