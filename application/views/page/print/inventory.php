<div class="container-fluid">
	
	<br>
	<div class="row">
		<div class="col-xs-4">
			<strong>Tanggal : <?php echo $header->inventory_date; ?></strong>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-xs-12">
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Barang</th>
						<th>Barcode</th>
						<th>Kadaluarsa</th>
						<th>Qty</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($products as $i=>$product) { ?>
						<tr>
							<td><?php echo $i+1; ?></td>
							<td><?php echo $product->name; ?></td>
							<td><?php echo $product->barcode; ?></td>
							<td><?php echo $product->expiry_date; ?></td>
							<td><?php echo $product->quantity; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row hidden-print">
		<div class="col-md-12">
			<a href="<?php echo base_url('inventory'); ?>" class="btn btn-default btn-small">Kembali</a>
		</div>
	</div>
</div>

