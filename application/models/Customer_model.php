<?php
	class Customer_model extends CI_Model {
		public function get($condition=NULL) {
			if($condition) {
				$this->db->where($condition);
			}
			$query = $this->db->get('customer');
			if($query->num_rows()>1) {
				return $query->result();
			}
			else {
				return $query->row();
			}
		}
	}