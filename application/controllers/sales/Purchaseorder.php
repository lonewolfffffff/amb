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
			$crud->fields('po_date','po_ref','customer_id','products');
			
			$crud->display_as('products','Barang');
			
			/* input grid */
			$crud->callback_add_field('products',array($this,'add_field_callback'));

			$output = $crud->render();
			$output->sidebar = 'sales_po';
			$output->page_title = 'Daftar PO';
			$output->custom_script = 'sales/po.js';
			
			$this->load->view('template/default/main',$output);
		}
		
		function add_field_callback() {
			return $this->load->view('widget/grid/purchase_order_detail','',TRUE);
		}
		
	}
