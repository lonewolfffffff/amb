<ul class="nav nav-sidebar">
	<li class="disabled"><a href="">Penjualan</a></li>
	<li class="<?php echo is_selected($sidebar,'sales_po'); ?>">
		<a href="<?php echo base_url('sales/purchaseorder'); ?>">PO</a>
	</li>
	<li class="<?php echo is_selected($sidebar,'sales_suratjalan'); ?>">
		<a href="<?php echo base_url('sales/suratjalan'); ?>">Surat Jalan</a>
	</li>
	<li class="<?php echo is_selected($sidebar,'sales_invoice'); ?>">
		<a href="<?php echo base_url('sales/invoice'); ?>">Invoice</a>
	</li>
	<li class="<?php echo is_selected($sidebar,'sales_retur'); ?>">
		<a href="<?php echo base_url('sales/retur'); ?>">Retur</a>
	</li>
</ul>
<ul class="nav nav-sidebar">
	<!-- <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li> -->
	<li class="disabled"><a href="">Laporan Penjualan</a></li>
	<li class="<?php echo is_selected($sidebar,'report_salesman'); ?>">
		<a href="<?php echo base_url('report/salesman'); ?>">Salesman</a>
	</li>
	<li class="<?php echo is_selected($sidebar,'report_product'); ?>">
		<a href="<?php echo base_url('report/product'); ?>">Barang</a>
	</li>
	<li class="<?php echo is_selected($sidebar,'report_customer'); ?>">
		<a href="<?php echo base_url('report/customer'); ?>">Customer</a>
	</li>
	<!-- <li class="disabled"><a href="">Analytics</a></li>
	<li class="disabled"><a href="">Export</a></li> -->
</ul>
<ul class="nav nav-sidebar">
	<li class="<?php echo is_selected($sidebar,'purchasing'); ?>">
		<a href="<?php echo base_url('purchasing'); ?>">Pembelian</a>
	</li>
</ul>
<ul class="nav nav-sidebar">
	<li class="<?php echo is_selected($sidebar,'product'); ?>">
		<a href="<?php echo base_url('product'); ?>">Daftar Produk dan Harga</a>
	</li>
	<li class="<?php echo is_selected($sidebar,'customer'); ?>">
		<a href="<?php echo base_url('customer'); ?>">Customer</a>
	</li>
	<li class="<?php echo is_selected($sidebar,'salesman'); ?>">
		<a href="<?php echo base_url('salesman'); ?>">Salesman</a>
	</li>
</ul>