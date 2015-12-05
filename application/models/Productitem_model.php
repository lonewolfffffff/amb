<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Productitem_model extends CI_Model {
		public function insert_batch($items) {
			$this->db->insert_batch('product_item',$items);
		}
		
		public function delete($inventory_id) {
			$this->db->where('inventory_id',$inventory_id);
			$this->db->delete('product_item');
		}
		
		public function get($condition) {
			if($condition) {
				$this->db->where($condition);
			}
			$query = $this->db->get_where('product_item');
			return $query->result();
		}
	}

