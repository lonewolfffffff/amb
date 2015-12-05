<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Suratjalandetail_model extends CI_Model {
		public function insert_batch($items) {
			$this->db->insert_batch('surat_jalan_detail',$items);
		}
		
		public function get($condition) {
			if($condition) {
				$this->db->where($condition);
			}
			$this->db->select('surat_jalan_detail.product_id,product.name,product.barcode,surat_jalan_detail.quantity,product.unit_price,discount_percentage,discount_amount,after_discount,tax,total,product.taxable');
			$this->db->from('surat_jalan_detail');
			$this->db->join('product','surat_jalan_detail.product_id=product.id');
			$query = $this->db->get();
			return $query->result();
		}
		
		public function delete($condition) {
			if($condition) {
				$this->db->where($condition);
			}
			$this->db->delete('surat_jalan_detail');
		}
	}

