<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Returngoods extends CI_Controller {
		public function __construct() {
			parent::__construct();
			
			if(!$this->session->userdata('user')) {
				redirect('login', 'refresh');
			}
		}
		
		public function index() {
			$crud = new grocery_CRUD();
 
			$crud->set_table('purchase_order');
			$crud->set_relation('customer_id','customer','name');
			
			$crud->display_as('po_date','Tanggal Retur')->display_as('customer_id','Customer')->display_as('products','Barang');
			$crud->columns('po_date','customer_id');
			$crud->fields('po_date','customer_id','products');
			/* input grid */
			$crud->callback_add_field('products',array($this,'add_field_callback'));
			$crud->callback_insert(array($this,'insert_callback'));

			$output = $crud->render();
			$output->sidebar = 'sales_retur';
			$output->page_title = 'Retur';
			$output->custom_script = 'sales/po.js';
			
			$this->load->view('template/default/main',$output);
		}
		
		public function add_field_callback() {
			$this->load->model('product_model');
			$products = $this->product_model->get_list();
			$product_list = array();
			foreach($products as $product) {
				$product_list[] = array('value'=>$product->id,'label'=>$product->name);
			}
			$data['product_list'] = json_encode($product_list);
			return $this->load->view('widget/grid/purchase_order_detail',$data,TRUE);
		}
		
		public function insert_callback($post_array) {
			$this->load->model('purchaseorder_model');
			$po_id = $this->purchaseorder_model->insert($post_array['po_date'],$post_array['po_ref'],$post_array['customer_id']);
			
			/* save grid */
			$po_items = explode(',', $post_array["po_items_rowOrder"]);
			$po_details = array();
			foreach($po_items as $item) {
				$po_details[] = array('po_id'=>$po_id,'product_id'=>$post_array['po_items_barang_'.$item],'quantity'=>$post_array['po_items_qty_'.$item]);
			}
			$this->load->model('purchaseorderdetail_model');
			$this->purchaseorderdetail_model->insert_batch($po_details);
			return TRUE;
		}
		
	}
