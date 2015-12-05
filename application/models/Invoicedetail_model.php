<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Invoicedetail_model extends CI_Model {
		public function insert_batch($items) {
			$this->db->insert_batch('invoice_detail',$items);
		}
		
		public function get($condition) {
			$this->db->where($condition);
			$this->db->select('invoice_id,product_id,product.name,product.barcode,quantity,invoice_detail.unit_price,discount_percentage,discount_amount,after_discount,total',FALSE);
			$this->db->from('invoice_detail');
			$this->db->join('product','invoice_detail.product_id=product.id');
			$query = $this->db->get();
			return $query->result();
		}
	}

