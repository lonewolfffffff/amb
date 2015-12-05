<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Customer extends CI_Controller {
		public function __construct() {
			parent::__construct();
		}
		
		public function index() {
			$crud = new grocery_CRUD();

			$crud->set_table('customer');
			$crud->display_as('name','Nama')
					->display_as('address','Alamat 1')
					->display_as('address2','Alamat 2')
					->display_as('phone','Telpon')
					->display_as('fax','Fax')
					->display_as('invoice_extra_info','Tampilkan rekening');
			
			$crud->callback_column('invoice_extra_info',array($this,'invoice_extra_info_column_callback'));
			$crud->callback_field('invoice_extra_info',array($this,'invoice_extra_info_field_callback'));
			
			$crud->required_fields('name','address','phone');

			$output = $crud->render();
			$output->sidebar = 'customer';
			$output->page_title = 'Daftar Pelanggan';
			
			$this->load->view('template/default/main',$output);
		}
		
		public function invoice_extra_info_column_callback($value,$row) {
			if($row->invoice_extra_info) {
				return 'Ya';
			}
			else {
				return 'Tidak';
			}
		}
		
		public function invoice_extra_info_field_callback($value) {
			$data = array(
				'name'=>'invoice_extra_info',
				'id'=>'field-invoice_extra_info',
			);
			$component = form_radio($data,1,$value).form_label('Ya','field-ppn');

			$data['id'] = 'field-non_ppn';
			$data['style'] = 'margin-left:20px;';
			$component .= form_radio($data,0,$value!=1).form_label('Tidak','field-non_ppn');
			return $component;
		}
		
		public function tax_type($customer_id) {
			$this->load->model('customer_model');
			$customer = $this->customer_model->get(array('id'=>$customer_id));
			header('Content-Type: application/json');
			echo json_encode((object) array('ppn'=>$customer->ppn));
		}
		
	}