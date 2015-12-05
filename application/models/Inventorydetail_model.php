<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Inventorydetail_model extends CI_Model {
		public function insert_batch($items) {
			$this->db->insert_batch('inventory_detail',$items);
		}
		
		public function delete($inventory_id) {
			$this->db->where('inventory_id',$inventory_id);
			$this->db->delete('inventory_detail');
		}
		
		public function get($condition) {
			if($condition) {
				$this->db->where($condition);
			}
			$this->db->select('inventory_detail.product_id,product.name,product.barcode,quantity,expiry_date');
			$this->db->from('inventory_detail');
			$this->db->join('product','inventory_detail.product_id=product.id');
			$query = $this->db->get();
			return $query->result();
		}
	}

