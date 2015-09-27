<?php
defined('BASEPATH') OR exit('No direct script access allowed');
	
class Product_model extends CI_Model {
	public function add($barcode,$name,$price) {
		$data = array(
			'barcode'=>$barcode,
			'name'=>$name,
			'price'=>$price
		);
		$this->db->insert('product',$data);
	}
	
	public function edit($id,$barcode,$name,$price) {
		$data = array(
			'barcode'=>$barcode,
			'name'=>$name,
			'price'=>$price
		);
		$this->db->where('id',$id);
		$this->db->update('product',$data);
	}
	
	public function delete($id) {
		$this->db->where('id',$id);
		$this->db->delete('product');
	}
	
	public function get_list() {
		$query = $this->db->get('product');
		return $query->result();
	}
	
	public function get() {
		
	}
}