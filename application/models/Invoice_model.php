<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Invoice_model extends CI_Model {
		public function insert($invoice_date,$invoice_ref,$salesman_id,$surat_jalan_id,$subtotal_before_tax,$tax,$net_total) {
			$invoice_date_converted = DateTime::createFromFormat ('d/m/Y',$invoice_date);
			$data = array(
				'invoice_date'=>$invoice_date_converted->format('Y-m-d'),
				'invoice_ref'=>$invoice_ref,
				'salesman_id'=>$salesman_id,
				'surat_jalan_id'=>$surat_jalan_id,
				'subtotal_before_tax'=>$subtotal_before_tax,
				'tax'=>$tax,
				'net_total'=>$net_total
			);
			$this->db->insert('invoice',$data);
			return $this->db->insert_id();
		}
		
		public function get($condition=NULL) {
			if($condition) {
				$this->db->where($condition);
			}
			$this->db->from('invoice');
			$this->db->join('surat_jalan','invoice.surat_jalan_id=surat_jalan.id');
			$this->db->join('customer','surat_jalan.customer_id=customer.id');
			$query = $this->db->get();
			if($query->num_rows()>1) {
				return $query->result();
			}
			else {
				return $query->row();
			}
		}
		
		public function get_last($month,$year) {
			$this->db->where('MONTH(invoice_date)='.$month.' AND YEAR(invoice_date)='.$year);
			$this->db->select_max('invoice_ref');
			$query = $this->db->get('invoice');
			return $query->row();
		}
	}