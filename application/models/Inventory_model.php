<?php
	class Inventory_model extends CI_Model {
		public function insert($inventory_date) {
			$inventory_date_converted = DateTime::createFromFormat ('d/m/Y',$inventory_date);
			$data = array('inventory_date'=>$inventory_date_converted->format('Y-m-d'));
			$this->db->insert('inventory',$data);
			return $this->db->insert_id();
		}
		
		public function update($inventory_id,$inventory_date) {
			$date_inventory = DateTime::createFromFormat('d/m/Y',$inventory_date);
			$data = array('inventory_date'=>$date_inventory->format('Y-m-d'));
			$this->db->where('id',$inventory_id);
			$this->db->update('inventory',$data);
		}
		
		public function get_total_by_product_id($product_id) {
			$query = $this->db->query("SELECT SUM(quantity) AS total FROM inventory_detail WHERE product_id=$product_id GROUP BY product_id");
			return $query->row();
			//return (object) array('total'=>0);
		}
		
		public function get($condition) {
			if($condition) {
				$this->db->where($condition);
			}
			
			$query = $this->db->get('inventory');
			if($query->num_rows()>1) {
				return $query->result();
			}
			else {
				return $query->row();
			}
		}
	}