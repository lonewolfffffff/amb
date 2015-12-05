<?php
	class Inventory_report_model extends CI_Model {
		public function get($date_start,$date_end) {
			$query = $this->db->query("
				SELECT 
					product.id,
					product.name,
					product.barcode,
					IFNULL(saldo_masuk.awal,0) AS saldo_awal_masuk,
					IFNULL(saldo_keluar.awal,0) AS saldo_awal_keluar,
					IFNULL(masuk.jumlah,0) AS jumlah_masuk,
					IFNULL(keluar.jumlah,0) AS jumlah_keluar
				FROM product
				LEFT JOIN (
					SELECT product_id,SUM(quantity) awal
					FROM inventory_detail 
					JOIN inventory ON inventory_detail.inventory_id=inventory.id 
					WHERE inventory.inventory_date<'$date_start'
					GROUP BY product_id
				) saldo_masuk ON product.id=saldo_masuk.product_id
				LEFT JOIN (
					SELECT product_id,SUM(quantity) awal
					FROM invoice_detail 
					JOIN invoice ON invoice_detail.invoice_id=invoice.id 
					WHERE invoice.invoice_date<'$date_start'
					GROUP BY product_id
				) saldo_keluar ON product.id=saldo_keluar.product_id
				LEFT JOIN (
					SELECT product_id,SUM(quantity) jumlah
					FROM inventory_detail 
					JOIN inventory ON inventory_detail.inventory_id=inventory.id 
					WHERE inventory.inventory_date BETWEEN '$date_start' AND '$date_end'
					GROUP BY product_id
				) masuk ON product.id=masuk.product_id
				LEFT JOIN (
					SELECT product_id,SUM(quantity) jumlah
					FROM invoice_detail 
					JOIN invoice ON invoice_detail.invoice_id=invoice.id 
					WHERE invoice.invoice_date BETWEEN '$date_start' AND '$date_end'
					GROUP BY product_id
				) keluar ON product.id=keluar.product_id
			");
			//var_dump($this->db->last_query());
			return $query->result();
		}
	}