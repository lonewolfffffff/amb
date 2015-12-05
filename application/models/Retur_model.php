<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Retur_model extends CI_Model {
		public function insert($po_date,$po_ref,$customer_id) {
			$po_date_converted = DateTime::createFromFormat ('d/m/Y',$po_date);
			$data = array('po_date'=>$po_date_converted->format('Y-m-d'),'po_ref'=>$po_ref,'customer_id'=>$customer_id);
			$this->db->insert('purchase_order',$data);
			return $this->db->insert_id();
		}
	}