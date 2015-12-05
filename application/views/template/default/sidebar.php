<ul class="nav nav-sidebar">
	<li class="disabled"><a href="">Penjualan</a></li>
	<li class="<?php echo is_selected($sidebar,'sales_suratjalan'); ?>">
		<a href="<?php echo base_url('sales/suratjalan'); ?>">Surat Jalan</a>
	</li>
	<li class="<?php echo is_selected($sidebar,'sales_invoice'); ?>">
		<a href="<?php echo base_url('sales/invoice'); ?>">Invoice</a>
	</li>
	<?php if(FALSE) { ?>
		<li class="<?php echo is_selected($sidebar,'sales_retur'); ?>">
			<a href="<?php echo base_url('sales/returngoods'); ?>">Retur</a>
		</li>
	<?php } ?>
</ul>
<ul class="nav nav-sidebar">
	<li class="<?php echo is_selected($sidebar,'report'); ?>">
		<a href="<?php echo base_url('sales/report'); ?>">Laporan Penjualan</a>
	</li>
</ul>
<ul class="nav nav-sidebar">
	<li class="<?php echo is_selected($sidebar,'inventory_report'); ?>">
		<a href="<?php echo base_url('inventory/report'); ?>">Laporan Stok</a>
	</li>
</ul>
<ul class="nav nav-sidebar">
	<li class="<?php echo is_selected($sidebar,'inventory'); ?>">
		<a href="<?php echo base_url('inventory'); ?>">Pembelian/Stok Opname</a>
	</li>
</ul>
<ul class="nav nav-sidebar">
	<li class="disabled"><a href="">Katalog</a></li>
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