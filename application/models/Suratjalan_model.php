<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Suratjalan_model extends CI_Model {
		public function insert($surat_jalan_date,$po_ref,$surat_jalan_ref,$customer_id,$net_total) {
			$surat_jalan_date_converted = DateTime::createFromFormat ('d/m/Y',$surat_jalan_date);
			$data = array('surat_jalan_date'=>$surat_jalan_date_converted->format('Y-m-d'),'po_ref'=>$po_ref,'surat_jalan_ref'=>$surat_jalan_ref,'customer_id'=>$customer_id,'net_total'=>$net_total);
			$this->db->insert('surat_jalan',$data);
			return $this->db->insert_id();
		}
		
		public function update($surat_jalan_id,$surat_jalan_date,$po_ref,$customer_id,$net_total) {
			$surat_jalan_date_converted = DateTime::createFromFormat ('d/m/Y',$surat_jalan_date);
			$data = array('surat_jalan_date'=>$surat_jalan_date_converted->format('Y-m-d'),'po_ref'=>$po_ref,'customer_id'=>$customer_id,'net_total'=>$net_total);
			$this->db->where('id',$surat_jalan_id);
			$this->db->update('surat_jalan',$data);
		}
		
		public function get($condition=NULL) {
			if($condition) {
				$this->db->where($condition);
			}
			$this->db->select('surat_jalan.id,surat_jalan_date,po_ref,surat_jalan_ref,customer_id,customer.name,customer.address,customer.address2,customer.invoice_extra_info,net_total');
			$this->db->from('surat_jalan');
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
			$this->db->where('MONTH(surat_jalan_date)='.$month.' AND YEAR(surat_jalan_date)='.$year);
			$this->db->select_max('surat_jalan_ref');
			$query = $this->db->get('surat_jalan');
			return $query->row();
		}
	}