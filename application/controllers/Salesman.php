<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Salesman extends CI_Controller {
		public function __construct() {
			parent::__construct();

			$this->load->database();

			$this->load->library('grocery_CRUD');
		}
		
		public function index() {
			$crud = new grocery_CRUD();

			$crud->set_table('salesman');

			$output = $crud->render();
			$output->sidebar = 'salesman';
			$output->page_title = 'Daftar Salesman';
			
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