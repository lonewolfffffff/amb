<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Report extends CI_Controller {
		public function index() {
			$data['sidebar'] = 'report';
			$data['page'] = 'report/sales';
			$data['page_title'] = 'Laporan Penjualan';
			$data['custom_script'] = 'report.js';
			
			$data['invoices'] = array();
			$data['report_daterange'] = $this->input->post('report_daterange');
			if($data['report_daterange']) {
				$report_daterange = explode(' - ',$data['report_daterange']);
				$date_start = DateTime::createFromFormat('d/m/Y',$report_daterange[0]);
				$date_end = DateTime::createFromFormat('d/m/Y',$report_daterange[1]);
				
				//$this->load->model('Invoice_report_model');
				//$invoices = $this->invoice_report_model->get($date_start->format('Y-m-d'),$date_end->format('Y-m-d'));
				//foreach($invoices as $invoice) {
					
				//}
				//$data['invoices'] = $invoices;
			}
			
			$this->load->view('template/default/main',$data);
		}
		
		public function salesman() {
			$data['sidebar'] = 'report_salesman';
			$data['page'] = 'report/salesman';
			$data['page_title'] = 'Laporan per Salesman';
			$data['custom_script'] = 'report.js';
			$this->load->view('template/default/main',$data);
		}
		
		public function product() {
			$data['sidebar'] = 'report_product';
			$data['page'] = 'report/product';
			$data['page_title'] = 'Laporan per Produk';
			$this->load->view('template/default/main',$data);
		}
		
		public function customer() {
			$data['sidebar'] = 'report_customer';
			$data['page'] = 'report/customer';
			$data['page_title'] = 'Laporan per Customer';
			$this->load->view('template/default/main',$data);
		}
	}