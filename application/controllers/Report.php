<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Report extends CI_Controller {
		public function salesman() {
			$data['sidebar'] = 'report_salesman';
			$this->load->view('template/admin/main',$data);
		}
		
		public function product() {
			$data['sidebar'] = 'report_product';
			$this->load->view('template/admin/main',$data);
		}
		
		public function customer() {
			$data['sidebar'] = 'report_customer';
			$this->load->view('template/admin/main',$data);
		}
	}