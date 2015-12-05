<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Returdetail_model extends CI_Model {
		public function insert_batch($items) {
			$this->db->insert_batch('purchase_order_detail',$items);
		}
	}

