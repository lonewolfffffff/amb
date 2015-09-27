<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Product extends CI_Controller {
		public function __construct() {
			parent::__construct();
			
			if(!$this->session->userdata('user')) {
				redirect('login', 'refresh');
			}
		}
		
		public function index() {
			
			$this->load->model('product_model');
			$data['products'] = $this->product_model->get_list();
			$data['sidebar'] = 'product';
			$data['page'] = 'product_pricelist';
			$this->load->view('template/admin/main',$data);
		}
	}