<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Product extends CI_Controller {
		public function __construct() {
			parent::__construct();

			$this->load->database();

			$this->load->library('grocery_CRUD');
		}
		
		public function index() {
			$crud = new grocery_CRUD();

			$crud->set_table('product');
			$crud->required_fields('name','unit_price');
			$crud->display_as('name','Nama barang')
					->display_as('unit_price','Harga satuan')
					->display_as('taxable','PPN');
			
			$crud->callback_column('taxable',array($this,'ppn_column_callback'));
			$crud->callback_field('taxable',array($this,'ppn_field_callback'));
			
			$output = $crud->render();
			$output->sidebar = 'product';
			$output->page_title = 'Daftar Produk dan Harga';
			
			$this->load->view('template/default/main',$output);

			/*
			$this->load->model('product_model');
			$data['products'] = $this->product_model->get_list();
			$data['sidebar'] = 'product';
			$data['page'] = 'product_pricelist';
			$this->load->view('template/admin/main',$data);
			*/
		}
		
		public function ppn_column_callback($value, $row) {
			if($row->taxable) {
				return 'PPN';
			}
			else {
				return 'Non-PPN';
			}
		}
		
		public function ppn_field_callback($value) {
			$data = array(
				'name'=>'taxable',
				'id'=>'field-taxable',
			);
			$component = form_radio($data,1,$value).form_label('PPN','field-taxable');

			$data['id'] = 'field-non_taxable';
			$data['style'] = 'margin-left:20px;';
			$component .= form_radio($data,0,$value!=1).form_label('Non-PPN','field-non_taxable');
			return $component;
		}
	}