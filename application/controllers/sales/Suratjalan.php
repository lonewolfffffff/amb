<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Suratjalan extends CI_Controller {
		public function __construct() {
			parent::__construct();
			
			if(!$this->session->userdata('user')) {
				redirect('login', 'refresh');
			}
		}
		
		public function index() {
			$crud = new grocery_CRUD();
 
			$crud->set_table('surat_jalan');
			$crud->set_subject('Surat Jalan');
			$crud->set_relation('customer_id','customer','{name} [{address}]');
			
			$crud->columns('surat_jalan_date','po_ref','surat_jalan_ref','customer_id','cetak','invoice');
			$crud->fields('surat_jalan_date','po_ref','surat_jalan_ref','customer_id','customer_address','products');
			$crud->field_type('customer_address', 'hidden');
			$crud->display_as('surat_jalan_date','Tanggal')
					->display_as('po_ref','Nomor PO')
					->display_as('surat_jalan_ref','Nomor Surat Jalan')
					->display_as('customer_id','Customer')
					->display_as('customer_address','Alamat')
					->display_as('cetak','')
					->display_as('invoice','')
					->display_as('products','Barang');
			
			/* list */
			$crud->callback_column('surat_jalan_ref',array($this,'surat_jalan_ref_column_callback'));
			$crud->callback_column('cetak',array($this,'cetak_column_callback'));
			$crud->callback_column('invoice',array($this,'invoice_column_callback'));
			
			/* header */
			$crud->required_fields('surat_jalan_date','customer_id');
			/* input grid */
			$crud->callback_add_field('surat_jalan_ref',array($this,'surat_jalan_ref_add_field_callback'));
			$crud->callback_edit_field('surat_jalan_ref',array($this,'surat_jalan_ref_edit_field_callback'));
			$crud->callback_add_field('products',array($this,'products_add_field_callback'));
			$crud->callback_edit_field('products',array($this,'products_edit_field_callback'));
			$crud->callback_insert(array($this,'insert_callback'));
			$crud->callback_update(array($this,'update_callback'));
			
			/* read/print mode */
			$crud->set_read_fields('id','surat_jalan_date','customer_id','customer_address','products');
			$crud->callback_read_field('id',array($this,'id_read_field_callback'));
			$crud->callback_read_field('surat_jalan_date',array($this,'surat_jalan_date_read_field_callback'));
			$crud->callback_read_field('customer_address',array($this,'customer_address_read_field_callback'));
			$crud->callback_read_field('products',array($this,'products_read_field_callback'));

			$output = $crud->render();
			$output->sidebar = 'sales_suratjalan';
			$output->page_title = 'Surat Jalan';
			$output->custom_script = 'inputgrid/sales/suratjalan.js';
			
			$this->load->view('template/default/main',$output);
		}
		
		public function surat_jalan_ref_column_callback($value,$row) {
			$surat_jalan_date = DateTime::createFromFormat ('d/m/Y',$row->surat_jalan_date);
			
			return $value.'/'.month_to_roman($surat_jalan_date->format('m')).'/'.$surat_jalan_date->format('Y');
		}
		
		public function cetak_column_callback($value,$row) {
			return '<a href="'.base_url('sales/suratjalan/printview/'.$row->id).'">Cetak/Lihat Surat Jalan</a>';
		}
		
		public function invoice_column_callback($value,$row) {
			return '<a href="'.base_url('sales/invoice/index/add/'.$row->id).'">Buat Invoice</a>';
		}
		
		public function surat_jalan_ref_add_field_callback() {
			$new_surat_jalan_ref = $this->get_last_ref(date('m'),date('Y'));
			return '<span id="span_surat_jalan_ref">'.$new_surat_jalan_ref.'</span><input type="hidden" id="input_surat_jalan_ref" name="surat_jalan_ref" value="'.$new_surat_jalan_ref.'">';
		}
		
		public function surat_jalan_ref_edit_field_callback($value, $primary_key) {
			$this->load->model('suratjalan_model');
			$surat_jalan = $this->suratjalan_model->get(array('surat_jalan.id'=>$primary_key));
			$surat_jalan_date = DateTime::createFromFormat ('Y-m-d',$surat_jalan->surat_jalan_date);
			return $value.'/'.month_to_roman($surat_jalan_date->format('m')).'/'.$surat_jalan_date->format('Y');
		}
		
		public function products_add_field_callback() {
			$data['net_total'] = 0;
			
			$this->load->model('product_model');
			$products = $this->product_model->get_list();
			$product_list = array(array('value'=>'','label'=>'[Pilih Produk]'));
			foreach($products as $product) {
				$product_list[] = array('value'=>$product->id,'label'=>$product->name,'unit_price'=>$product->unit_price,'ppn'=>$product->taxable);
			}
			$data['product_list'] = json_encode($product_list);
			
			$data['grid_data'] = json_encode(array(array('product_id'=>'','quantity'=>'')));
			return $this->load->view('widget/grid/surat_jalan_detail',$data,TRUE);
		}
		
		public function products_edit_field_callback($value, $primary_key) {
			$this->load->model('suratjalan_model');
			$surat_jalan = $this->suratjalan_model->get(array('surat_jalan.id'=>$primary_key));
			$data['net_total'] = $surat_jalan->net_total;
			$this->load->model('product_model');
			$products = $this->product_model->get_list();
			$product_list = array(array('value'=>'','label'=>'[Pilih Produk]'));
			foreach($products as $product) {
				$product_list[] = array('value'=>$product->id,'label'=>$product->name,'unit_price'=>$product->unit_price,'ppn'=>$product->taxable);
			}
			$data['product_list'] = json_encode($product_list);
			
			$this->load->model('suratjalandetail_model');
			$surat_jalan_detail = $this->suratjalandetail_model->get(array('surat_jalan_id'=>$primary_key));
			$grid_data = array();
			foreach($surat_jalan_detail as $detail) {
				$grid_data[] = array(
					'taxable'=>($detail->tax>0),
					'product_id'=>$detail->product_id,
					'quantity'=>$detail->quantity,
					'unit_price'=>$detail->unit_price,
					'discount_percentage'=>$detail->discount_percentage,
					'discount_amount'=>$detail->discount_amount,
					'after_discount'=>$detail->after_discount,
					'tax'=>$detail->tax,
					'total'=>$detail->total,
				);
			}
			$data['grid_data'] = json_encode($grid_data);
			return $this->load->view('widget/grid/surat_jalan_detail',$data,TRUE);
		}
		
		public function insert_callback($post_array) {
			$this->load->model('suratjalan_model');
			$surat_jalan_id = $this->suratjalan_model->insert($post_array['surat_jalan_date'],$post_array['po_ref'],$post_array['surat_jalan_ref'],$post_array['customer_id'],$post_array['net_total']);
			
			/* save grid */
			$surat_jalan_items = explode(',', $post_array["sj_items_rowOrder"]);
			$sj_details = array();
			foreach($surat_jalan_items as $item) {
				$sj_details[] = array(
					'surat_jalan_id'=>$surat_jalan_id,
					'product_id'=>$post_array['sj_items_product_id_'.$item],
					'quantity'=>$post_array['sj_items_quantity_'.$item],
					'unit_price'=>$post_array['sj_items_unit_price_'.$item],
					'discount_percentage'=>$post_array['sj_items_discount_percentage_'.$item],
					'discount_amount'=>$post_array['sj_items_discount_amount_'.$item],
					'after_discount'=>$post_array['sj_items_after_discount_'.$item],
					'tax'=>$post_array['sj_items_tax_'.$item],
					'total'=>$post_array['sj_items_total_'.$item]
				);
			}
			$this->load->model('suratjalandetail_model');
			$this->suratjalandetail_model->insert_batch($sj_details);
			return TRUE;
		}
		
		public function update_callback($post_array,$primary_key) {
			$this->load->model('suratjalan_model');
			$this->suratjalan_model->update($primary_key,$post_array['surat_jalan_date'],$post_array['po_ref'],$post_array['customer_id'],$post_array['net_total']);
			
			/* save grid */
			$surat_jalan_items = explode(',', $post_array["sj_items_rowOrder"]);
			$sj_details = array();
			foreach($surat_jalan_items as $item) {
				$sj_details[] = array(
					'surat_jalan_id'=>$primary_key,
					'product_id'=>$post_array['sj_items_product_id_'.$item],
					'quantity'=>$post_array['sj_items_quantity_'.$item],
					'unit_price'=>$post_array['sj_items_unit_price_'.$item],
					'discount_percentage'=>$post_array['sj_items_discount_percentage_'.$item],
					'discount_amount'=>$post_array['sj_items_discount_amount_'.$item],
					'after_discount'=>$post_array['sj_items_after_discount_'.$item],
					'tax'=>$post_array['sj_items_tax_'.$item],
					'total'=>$post_array['sj_items_total_'.$item]
				);
			}
			$this->load->model('suratjalandetail_model');
			$this->suratjalandetail_model->delete(array('surat_jalan_id'=>$primary_key));
			$this->suratjalandetail_model->insert_batch($sj_details);
			return TRUE;
		}
		
		public function id_read_field_callback($value,$primary_key) {
			return '<div class="readonly_label" id="field-id">4</div>';
		}
		
		public function surat_jalan_date_read_field_callback($value,$primary_key) {
			$surat_jalan_date = DateTime::createFromFormat ('Y-m-d',$value);
			return '<div class="readonly_label" id="field-surat_jalan_date">'.$surat_jalan_date->format('d/m/Y').'</div>';
		}
		
		public function customer_address_read_field_callback($value,$primary_key) {
			$this->load->model('suratjalan_model');
			$surat_jalan = $this->suratjalan_model->get(array('surat_jalan.id'=>$primary_key));
			return '<div class="readonly_label" id="field-customer_address">'.$surat_jalan->address.'</div>';
		}
		
		public function products_read_field_callback($value,$primary_key) {
			$this->load->model('suratjalandetail_model');
			$data = array('products'=>$this->suratjalandetail_model->get(array('surat_jalan_id'=>$primary_key)));
			return $this->load->view('widget/read/surat_jalan_detail',$data,TRUE);
		}
		
		public function printview($surat_jalan_id) {
			$this->load->model('suratjalan_model');
			$data = array('header'=>$this->suratjalan_model->get(array('surat_jalan.id'=>$surat_jalan_id)));
			$surat_jalan_date = DateTime::createFromFormat ('Y-m-d',$data['header']->surat_jalan_date);
			$data['header']->surat_jalan_date = $surat_jalan_date->format('d-m-Y');
			$data['header']->surat_jalan_ref = $data['header']->surat_jalan_ref.'/'.month_to_roman($surat_jalan_date->format('m')).'/'.$surat_jalan_date->format('Y');
			$this->load->model('suratjalandetail_model');
			$data['products'] = $this->suratjalandetail_model->get(array('surat_jalan_id'=>$surat_jalan_id));
			foreach($data['products'] as $product) {
				$product->discount = 0;
				$product->total_before_discount_distribution = $product->after_discount * $product->quantity;
			}
			$data['page'] = 'print/suratjalan';
			$data['sidebar'] = 'sales_suratjalan';
			$data['custom_script'] = 'print.js';
			$this->load->view('template/print/main',$data);
		}
		
		public function get_last_ref($month,$year,$ajax=0) {
			$this->load->model('suratjalan_model');
			$last = $this->suratjalan_model->get_last($month,$year);
			$new_surat_jalan_ref = 0;
			if($last->surat_jalan_ref) {
				$new_surat_jalan_ref = (int) $last->surat_jalan_ref;
			}
			
			$format = ($new_surat_jalan_ref+1).'/'.month_to_roman($month).'/'.$year;
			if($ajax) {
				header('Content-Type: application/json');
				echo json_encode(array('new_surat_jalan_ref'=>$format));
			}
			else {
				return $format;
			}
		}
	}
