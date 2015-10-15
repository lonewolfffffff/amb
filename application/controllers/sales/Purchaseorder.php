<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Purchaseorder extends CI_Controller {
		public function __construct() {
			parent::__construct();
			
			if(!$this->session->userdata('user')) {
				redirect('login', 'refresh');
			}
		}
		
		public function index() {
			$crud = new grocery_CRUD();
 
			$crud->set_table('purchase_order');
			$crud->set_relation('customer_id','customer','name');
			
			$crud->display_as('has_details','Barang');
			
			/* input grid */
			$crud->callback_add_field('has_details',array($this,'add_field_callback_1'));

			$output = $crud->render();
			$output->sidebar = 'sales_po';
			$output->page_title = 'Daftar PO';
			
			$this->load->view('template/default/main',$output);
		}
		
		public function add() {
			
		}
		
		public function edit() {
			
		}
		
		public function delete() {
			
		}
		
		function add_field_callback_1() {
			return $this->load->view('widget/grid/purchase_order_detail','',TRUE);
		}
		
	}
