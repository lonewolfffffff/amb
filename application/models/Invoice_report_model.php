<?php
	class Invoice_report_model extends CI_Model {
		public function get($date_start,$date_end) {
			$query = $this->db->query("
				SELECT 
					invoice_date,
					invoice_ref,
					po_ref,
					surat_jalan_ref,
					surat_jalan_date,
					customer.name AS customer_name,
					customer.address AS customer_address,
					invoice.net_total
				FROM invoice
				JOIN surat_jalan ON invoice.surat_jalan_id=surat_jalan.id
				JOIN customer ON surat_jalan.customer_id=customer.id
				WHERE invoice_date BETWEEN '$date_start' AND '$date_end'
			");
			return $query->result();
		}
	}
