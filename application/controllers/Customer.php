<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Customer extends CI_Controller {
		public function __construct() {
			parent::__construct();
		}
		
		public function index() {
			$crud = new grocery_CRUD();

			$crud->set_table('customer');

			$output = $crud->render();
			$output->sidebar = 'customer';
			$output->page_title = 'Daftar Klien';
			
			$this->load->view('template/default/main',$output);

			/*
			$this->load->model('product_model');
			$data['products'] = $this->product_model->get_list();
			$data['sidebar'] = 'product';
			$data['page'] = 'product_pricelist';
			$this->load->view('template/admin/main',$data);
			*/
		}
	}