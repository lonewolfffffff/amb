<?php
	class Inventory extends CI_Controller {
		public function index() {
			$crud = new grocery_CRUD();
 
			$crud->set_table('inventory');
			$crud->set_subject('Stok');
			
			$crud->columns('inventory_date','lihat');
			$crud->fields('inventory_date','products');
			$crud->display_as('inventory_date','Tanggal')->display_as('products','Barang')->display_as('lihat','');
			
			$crud->callback_column('lihat',array($this,'lihat_column_callback'));
			
			$crud->callback_add_field('products',array($this,'product_add_field_callback'));
			$crud->callback_edit_field('products',array($this,'product_edit_field_callback'));
			$crud->callback_insert(array($this,'insert_callback'));
			$crud->callback_update(array($this,'update_callback'));
			
			$output = $crud->render();
			$output->sidebar = 'inventory';
			$output->page_title = 'Pembelian/Stok Opname';
			$output->custom_script = 'inputgrid/inventory.js';
			
			$this->load->view('template/default/main',$output);
		}
		
		public function lihat_column_callback($value,$row) {
			return '<a href="'.base_url('inventory/printview/'.$row->id).'">Lihat data pembelian/stok opname</a>';
		}
		
		public function product_add_field_callback() {
			$this->load->model('product_model');
			$products = $this->product_model->get_list();
			$product_list = array();
			foreach($products as $product) {
				$product_list[] = array('value'=>$product->id,'label'=>$product->name);
			}
			$data['product_list'] = json_encode($product_list);
			$grid_data = array(array('product_id'=>'','quantity'=>''));
			$data['grid_data'] = json_encode($grid_data);
			return $this->load->view('widget/grid/inventory_detail',$data,TRUE);
		}
		
		public function product_edit_field_callback($value, $primary_key) {
			$this->load->model('inventory_model');
			$data = array('header'=>$this->inventory_model->get(array('id'=>$primary_key)));
			
			$this->load->model('product_model');
			$products = $this->product_model->get_list();
			$product_list = array();
			foreach($products as $product) {
				$product_list[] = array('value'=>$product->id,'label'=>$product->name);
			}
			$data['product_list'] = json_encode($product_list);
			
			$this->load->model('inventorydetail_model');
			$inventory_detail = $this->inventorydetail_model->get(array('inventory_id'=>$primary_key));
			$grid_data = array();
			foreach($inventory_detail as $detail) {
				$expiry_date = DateTime::createFromFormat ('Y-m-d',$detail->expiry_date);
				$grid_data[] = array(
					'product_id'=>$detail->product_id,
					'expiry_date'=>$expiry_date->format('d/m/Y'),
					'quantity'=>$detail->quantity
				);
			}
			$data['grid_data'] = json_encode($grid_data);
			return $this->load->view('widget/grid/inventory_detail',$data,TRUE);
		}
		
		public function insert_callback($post_array) {
			$this->load->model('inventory_model');
			$inventory_id = $this->inventory_model->insert($post_array['inventory_date']);
			
			/* save grid */
			$inventory_items = explode(',', $post_array["inventory_items_rowOrder"]);
			$inventory_details = array();
			$product_items = array();
			foreach($inventory_items as $item) {
				if($post_array['inventory_items_expiry_date_'.$item]) {
					$expiry_date = DateTime::createFromFormat('d/m/Y',$post_array['inventory_items_expiry_date_'.$item]);
					$inventory_details[] = array('inventory_id'=>$inventory_id,'product_id'=>$post_array['inventory_items_product_id_'.$item],'quantity'=>$post_array['inventory_items_quantity_'.$item],'expiry_date'=>$expiry_date->format('Y-m-d'));
				}
				else {
					$inventory_details[] = array('inventory_id'=>$inventory_id,'product_id'=>$post_array['inventory_items_product_id_'.$item],'quantity'=>$post_array['inventory_items_quantity_'.$item],'expiry_date'=>'');
				}
				$n_items = 0+$post_array['inventory_items_quantity_'.$item];
				for($i=0;$i<$n_items;$i++) {
					if($post_array['inventory_items_expiry_date_'.$item]) {
						$product_items[] = array('inventory_id'=>$inventory_id,'product_id'=>$post_array['inventory_items_product_id_'.$item],'expiry_date'=>$expiry_date->format('Y-m-d'));
					}
					else {
						$product_items[] = array('inventory_id'=>$inventory_id,'product_id'=>$post_array['inventory_items_product_id_'.$item],'expiry_date'=>'');
					}
				}
			}
			$this->load->model('inventorydetail_model');
			$this->inventorydetail_model->insert_batch($inventory_details);
			
			$this->load->model('productitem_model');
			$this->productitem_model->insert_batch($product_items);
			return TRUE;
		}
		
		public function update_callback($post_array,$primary_key) {
			$this->load->model('inventory_model');
			$this->inventory_model->update($primary_key,$post_array['inventory_date']);
			
			/* save grid */
			$inventory_items = explode(',', $post_array["inventory_items_rowOrder"]);
			$inventory_details = array();
			$product_items = array();
			foreach($inventory_items as $item) {
				if($post_array['inventory_items_expiry_date_'.$item]) {
					$expiry_date = DateTime::createFromFormat('d/m/Y',$post_array['inventory_items_expiry_date_'.$item]);
					$inventory_details[] = array('inventory_id'=>$primary_key,'product_id'=>$post_array['inventory_items_product_id_'.$item],'quantity'=>$post_array['inventory_items_quantity_'.$item],'expiry_date'=>$expiry_date->format('Y-m-d'));
				}
				else {
					$inventory_details[] = array('inventory_id'=>$primary_key,'product_id'=>$post_array['inventory_items_product_id_'.$item],'quantity'=>$post_array['inventory_items_quantity_'.$item],'expiry_date'=>'');
				}
				$n_items = 0+$post_array['inventory_items_quantity_'.$item];
				for($i=0;$i<$n_items;$i++) {
					if($post_array['inventory_items_expiry_date_'.$item]) {
						$product_items[] = array('inventory_id'=>$primary_key,'product_id'=>$post_array['inventory_items_product_id_'.$item],'expiry_date'=>$expiry_date->format('Y-m-d'));
					}
					else {
						$product_items[] = array('inventory_id'=>$primary_key,'product_id'=>$post_array['inventory_items_product_id_'.$item],'expiry_date'=>'');
					}
				}
			}
			$this->load->model('inventorydetail_model');
			$this->inventorydetail_model->delete($primary_key);
			$this->inventorydetail_model->insert_batch($inventory_details);
			
			$this->load->model('productitem_model');
			$this->productitem_model->delete($primary_key);
			$this->productitem_model->insert_batch($product_items);
			return TRUE;
		}
		
		public function report() {
			$output = new stdClass();
			$output->products = array();
			
			$output->report_daterange = $this->input->post('report_daterange');
			if($output->report_daterange) {
				$report_daterange = explode(' - ',$output->report_daterange);
				$date_start = DateTime::createFromFormat('d/m/Y',$report_daterange[0]);
				$date_end = DateTime::createFromFormat('d/m/Y',$report_daterange[1]);
				$this->load->model('inventory_report_model');
				$products = $this->inventory_report_model->get($date_start->format('Y-m-d'),$date_end->format('Y-m-d'));
				foreach($products as $product) {
					$product->saldo_awal = $product->saldo_awal_masuk-$product->saldo_awal_keluar;
					$product->saldo_akhir = $product->saldo_awal + $product->jumlah_masuk - $product->jumlah_keluar;
				}
				$output->products = $products;
			}
			
			$output->page = 'report/inventory';
			$output->sidebar = 'inventory_report';
			$output->page_title = 'Laporan Stok';
			$output->custom_script = 'report.js';
			$this->load->view('template/default/main',$output);
		}
		
		public function total_column_callback($value,$row) {
			$this->load->model('inventory_model');
			$product = $this->inventory_model->get_total_by_product_id($row->id);
			if($product) {
				return $product->total;
			}
			else {
				return '0';
			}
		}
		
		public function printview($inventory_id) {
			$this->load->model('inventory_model');
			$data = array('header'=>$this->inventory_model->get(array('id'=>$inventory_id)));
			$inventory_date = DateTime::createFromFormat ('Y-m-d',$data['header']->inventory_date);
			$data['header']->inventory_date = $inventory_date->format('d-m-Y');
			$this->load->model('inventorydetail_model');
			$data['products'] = $this->inventorydetail_model->get(array('inventory_id'=>$inventory_id));
			foreach($data['products'] as $product) {
				$expiry_date = DateTime::createFromFormat ('Y-m-d',$product->expiry_date);
				$product->expiry_date = $expiry_date->format('d-m-Y');
			}
			$data['page'] = 'print/inventory';
			$data['sidebar'] = 'inventory';
			$data['custom_script'] = 'print.js';
			$this->load->view('template/print/main',$data);
		}
		
		public function detail_report() {
			
		}
	}