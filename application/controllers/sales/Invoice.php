<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Invoice extends CI_Controller {
		public function __construct() {
			parent::__construct();
			
			if(!$this->session->userdata('user')) {
				redirect('login', 'refresh');
			}
		}
		
		public function index() {
			$crud = new grocery_CRUD();
			$crud->unset_edit();
			$crud->set_table('invoice');
			$crud->set_subject('Invoice');
			
			$crud->columns('invoice_date','invoice_ref','surat_jalan_ref','customer','salesman.name','cetak');
			$crud->fields('invoice_date','invoice_ref','surat_jalan_id','customer','salesman_id','products');
			
			$crud->display_as('invoice_date','Tanggal Invoice')
					->display_as('invoice_ref','Nomor Invoice')
					->display_as('salesman_id','Salesman')
					->display_as('surat_jalan_ref','Surat Jalan')
					->display_as('customer','Customer')
					->display_as('products','Barang');
			
			$crud->set_relation('salesman_id','salesman','name');
			
			/* list */
			$crud->callback_column('invoice_ref',array($this,'invoice_ref_column_callback'));
			$crud->callback_column('surat_jalan_ref',array($this,'surat_jalan_ref_column_callback'));
			$crud->callback_column('customer',array($this,'customer_column_callback'));
			$crud->callback_column('salesman',array($this,'salesman_column_callback'));
			$crud->callback_column('cetak',array($this,'cetak_column_callback'));
			
			/* input grid */
			$crud->callback_add_field('invoice_ref',array($this,'invoice_ref_add_field_callback'));
			$crud->callback_edit_field('invoice_ref',array($this,'invoice_ref_edit_field_callback'));
			$crud->callback_field('surat_jalan_id',array($this,'surat_jalan_id_field_callback'));
			$crud->callback_field('customer',array($this,'customer_field_callback'));
			$crud->callback_add_field('products',array($this,'product_add_field_callback'));
			$crud->callback_edit_field('products',array($this,'product_edit_field_callback'));
			$crud->callback_insert(array($this,'insert_callback'));

			$output = $crud->render();
			$output->sidebar = 'sales_invoice';
			$output->page_title = 'Invoice';
			$output->custom_script = 'inputgrid/sales/invoice.js';
			
			$this->load->view('template/default/main',$output);
		}
		
		public function invoice_ref_column_callback($value,$row) {
			$invoice_date = DateTime::createFromFormat ('d/m/Y',$row->invoice_date);
			return $value.'/'.month_to_roman($invoice_date->format('m')).'/'.$invoice_date->format('Y');;
		}
		
		public function surat_jalan_ref_column_callback($value,$row) {
			$this->load->model('suratjalan_model');
			$surat_jalan = $this->suratjalan_model->get(array('surat_jalan.id'=>$row->surat_jalan_id));
			$surat_jalan_date = DateTime::createFromFormat ('Y-m-d',$surat_jalan->surat_jalan_date);
			$surat_jalan_ref = $surat_jalan->surat_jalan_ref.'/'.month_to_roman($surat_jalan_date->format('m')).'/'.$surat_jalan_date->format('Y');
			return $surat_jalan_ref;
		}
		
		public function customer_column_callback($value,$row) {
			$this->load->model('suratjalan_model');
			$surat_jalan = $this->suratjalan_model->get(array('surat_jalan.id'=>$row->surat_jalan_id));
			return $surat_jalan->name.'['.$surat_jalan->address.']';
		}
		
		public function salesman_column_callback($value,$row) {
			$this->load->model('suratjalan_model');
			$surat_jalan = $this->suratjalan_model->get(array('surat_jalan.id'=>$row->surat_jalan_id));
			return print_r($row,TRUE);
		}
		
		public function cetak_column_callback($value,$row) {
			return '<a href="'.base_url('sales/invoice/printview/'.$row->id).'">Cetak/Lihat Invoice</a>';
		}
		
		public function invoice_ref_add_field_callback() {
			$new_invoice_ref = $this->get_last_ref(date('m'),date('Y'));
			return '<span id="span_invoice_ref">'.$new_invoice_ref.'</span><input type="hidden" id="input_invoice_ref" name="invoice_ref" value="'.$new_invoice_ref.'">';
		}
		
		public function invoice_ref_edit_field_callback($value, $primary_key) {
			$this->load->model('invoice_model');
			$invoice = $this->invoice_model->get(array('invoice.id'=>$primary_key));
			$invoice_date = DateTime::createFromFormat ('Y-m-d',$invoice->invoice_date);
			return $value.'/'.month_to_roman($invoice_date->format('m')).'/'.$invoice_date->format('Y');
		}
		
		public function surat_jalan_id_field_callback() {
			$surat_jalan_id = $this->uri->segment(5, 0);
			if($surat_jalan_id) {
				$this->load->model('suratjalan_model');
				$surat_jalan = $this->suratjalan_model->get(array('surat_jalan.id'=>$surat_jalan_id));
				$surat_jalan_date = DateTime::createFromFormat ('Y-m-d',$surat_jalan->surat_jalan_date);
				$surat_jalan_ref = $surat_jalan->surat_jalan_ref.'/'.month_to_roman($surat_jalan_date->format('m')).'/'.$surat_jalan_date->format('Y');
			}
			else {
				$surat_jalan_ref = '-';
			}
			return $surat_jalan_ref.'<input type="hidden" name="surat_jalan_id" value="'.$surat_jalan_id.'">';
		}
		
		public function customer_field_callback() {
			$surat_jalan_id = $this->uri->segment(5, 0);
			$surat_jalan = NULL;
			if($surat_jalan_id) {
				$this->load->model('suratjalan_model');
				$surat_jalan = $this->suratjalan_model->get(array('surat_jalan.id'=>$surat_jalan_id));
			}
			if($surat_jalan) {
				return ''.$surat_jalan->name.'<br/>'.$surat_jalan->address;
			}
			else {
				return '';
			}
			
		}
		
		public function product_add_field_callback() {
			$this->load->model('product_model');
			$products = $this->product_model->get_list();
			$product_list = array();
			foreach($products as $product) {
				$product_list[] = array('value'=>$product->id,'label'=>$product->name);
			}
			$data['product_list'] = json_encode($product_list);
			$surat_jalan_id = $this->uri->segment(5, 0);
			if($surat_jalan_id) {
				$this->load->model('suratjalan_model');
				$surat_jalan = $this->suratjalan_model->get(array('surat_jalan.id'=>$surat_jalan_id));
				
				$this->load->model('suratjalandetail_model');
				$grid_data = $this->suratjalandetail_model->get(array('surat_jalan_id'=>$surat_jalan_id));
				foreach($grid_data as $invoice_detail) {
					$invoice_detail->after_discount = $invoice_detail->unit_price;
					$invoice_detail->total = $invoice_detail->quantity * $invoice_detail->after_discount;
				}
			}
			else {
				$grid_data = array(array('product_id'=>'','quantity'=>''));
				$data['ppn'] = 0;
			}
			
			$data['grid_data'] = json_encode($grid_data);
			return $this->load->view('widget/grid/invoice_detail',$data,TRUE);
		}
		
		public function product_edit_field_callback($value, $primary_key) {
			$this->load->model('product_model');
			$products = $this->product_model->get_list();
			$product_list = array();
			foreach($products as $product) {
				$product_list[] = array('value'=>$product->id,'label'=>$product->name);
			}
			$data['product_list'] = json_encode($product_list);
			
			$this->load->model('invoicedetail_model');
			$grid_data = $this->invoicedetail_model->get(array('invoice_id'=>$primary_key));
			
			$data['grid_data'] = json_encode($grid_data);
			return $this->load->view('widget/grid/invoice_detail',$data,TRUE);
		}
		
		public function insert_callback($post_array) {
			$this->load->model('invoice_model');
			$invoice_id = $this->invoice_model->insert($post_array['invoice_date'],$post_array['invoice_ref'],$post_array['salesman_id'],$post_array['surat_jalan_id'],$post_array['subtotal_before_tax'],$post_array['tax'],$post_array['net_total']);
			
			/* save grid */
			$invoice_items = explode(',', $post_array["invoice_items_rowOrder"]);
			$invoice_details = array();
			foreach($invoice_items as $item) {
				$invoice_details[] = array(
					'invoice_id'=>$invoice_id,
					'product_id'=>$post_array['invoice_items_product_id_'.$item],
					'quantity'=>$post_array['invoice_items_quantity_'.$item],
					'unit_price'=>$post_array['invoice_items_unit_price_'.$item],
					'discount_percentage'=>$post_array['invoice_items_discount_percentage_'.$item],
					'discount_amount'=>$post_array['invoice_items_discount_amount_'.$item],
					'after_discount'=>$post_array['invoice_items_after_discount_'.$item],
					'total'=>$post_array['invoice_items_total_'.$item]
				);
			}
			$this->load->model('invoicedetail_model');
			$this->invoicedetail_model->insert_batch($invoice_details);
			return TRUE;
		}
		
		public function printview($invoice_id) {
			$this->load->model('invoice_model');
			$data = array('header'=>$this->invoice_model->get(array('invoice.id'=>$invoice_id)));
			$invoice_date = DateTime::createFromFormat ('Y-m-d',$data['header']->invoice_date);
			$data['header']->invoice_date = $invoice_date->format('d-m-Y');
			$data['header']->invoice_ref = $data['header']->invoice_ref.'/'.month_to_roman($invoice_date->format('m')).'/'.$invoice_date->format('Y');
			$this->load->model('invoicedetail_model');
			$data['products'] = $this->invoicedetail_model->get(array('invoice_id'=>$invoice_id));
			foreach($data['products'] as $product) {
				$product->discount = 0;
				$product->total_before_discount_distribution = $product->after_discount * $product->quantity;
			}
			$data['page'] = 'print/invoice';
			$data['sidebar'] = 'sales_invoice';
			$data['custom_script'] = 'print.js';
			$this->load->view('template/print/main',$data);
		}
		
		public function get_last_ref($month,$year,$ajax=0) {
			$this->load->model('invoice_model');
			$last = $this->invoice_model->get_last($month,$year);
			$new_invoice_ref = 0;
			if($last->invoice_ref) {
				$new_invoice_ref = (int) $last->invoice_ref;
			}
			
			$format = ($new_invoice_ref+1).'/'.month_to_roman($month).'/'.$year;
			if($ajax) {
				header('Content-Type: application/json');
				echo json_encode(array('new_invoice_ref'=>$format));
			}
			else {
				return $format;
			}
		}
		
	}
