<?php
	class Purchaseorder extends CI_Controller {
		public function index() {
			$crud = new grocery_CRUD();
 
			$crud->set_table('purchase_order');
			$crud->set_subject('PO');
			$crud->set_relation('customer_id','customer','name');
			
			$crud->columns('po_date','po_ref','customer_id','surat_jalan');
			$crud->fields('po_date','po_ref','customer_id','products');
			
			$crud->display_as('po_date','Tanggal PO')
					->display_as('po_ref','Nomor PO')
					->display_as('customer_id','Customer')
					->display_as('products','Barang')
					->display_as('surat_jalan','');
			
			/* list */
			$crud->callback_column('surat_jalan',array($this,'surat_jalan_column_callback'));
			
			/* input grid */
			$crud->callback_add_field('products',array($this,'add_field_callback'));
			$crud->callback_insert(array($this,'insert_callback'));
			
			$output = $crud->render();
			$output->sidebar = 'sales_po';
			$output->page_title = 'PO';
			$output->custom_script = 'inputgrid/sales/po.js';
			
			$this->load->view('template/default/main',$output);
		}
		
		public function surat_jalan_column_callback($value,$row) {
			return '<a href="'.base_url('sales/suratjalan/index/add/'.$row->id).'">Buat Surat Jalan</a>';
		}
		
		public function add_field_callback() {
			$this->load->model('product_model');
			$products = $this->product_model->get_list();
			$product_list = array();
			foreach($products as $product) {
				$product_list[] = array('value'=>$product->id,'label'=>$product->name);
			}
			$data['product_list'] = json_encode($product_list);
			$grid_data = array(array('product_id'=>'','quantity'=>''));
			$data['grid_data'] = json_encode($grid_data);
			return $this->load->view('widget/grid/purchase_order_detail',$data,TRUE);
		}
		
		public function insert_callback($post_array) {
			$this->load->model('purchaseorder_model');
			$po_id = $this->purchaseorder_model->insert($post_array['po_date'],$post_array['po_ref'],$post_array['customer_id']);
			
			/* save grid */
			$po_items = explode(',', $post_array["po_items_rowOrder"]);
			$po_details = array();
			foreach($po_items as $item) {
				$po_details[] = array('po_id'=>$po_id,'product_id'=>$post_array['po_items_product_id_'.$item],'quantity'=>$post_array['po_items_quantity_'.$item]);
			}
			$this->load->model('purchaseorderdetail_model');
			$this->purchaseorderdetail_model->insert_batch($po_details);
			return TRUE;
		}
	}