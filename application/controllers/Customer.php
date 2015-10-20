<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Customer extends CI_Controller {
		public function __construct() {
			parent::__construct();
		}
		
		public function index() {
			$crud = new grocery_CRUD();

			$crud->set_table('customer');
			$crud->display_as('ppn','');
			$crud->callback_column('ppn',array($this,'ppn_column_callback'));
			$crud->callback_field('ppn',array($this,'ppn_field_callback'));

			$output = $crud->render();
			$output->sidebar = 'customer';
			$output->page_title = 'Daftar Pelanggan';
			
			$this->load->view('template/default/main',$output);
		}
		
		public function ppn_column_callback($value, $row) {
			if($row->ppn) {
				return 'PPN';
			}
			else {
				return 'Non-PPN';
			}
		}
		
		public function ppn_field_callback($value) {
			$data = array(
				'name'=>'ppn',
				'id'=>'field-ppn',
			);
			$component = form_radio($data,1,$value).form_label('PPN','field-ppn');

			$data['id'] = 'field-non_ppn';
			$data['style'] = 'margin-left:20px;';
			$component .= form_radio($data,0,$value!=1).form_label('Non-PPN','field-non_ppn');
			return $component;
		}
		
	}