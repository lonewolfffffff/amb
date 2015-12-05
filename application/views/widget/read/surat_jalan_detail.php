<table class="table table-bordered">
	<thead>
		<tr>
			<th>Nama Barang</th>
			<th>Barcode</th>
			<th>Qty</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($products as $product) { ?>
		<tr>
			<td><?php echo $product->name; ?></td>
			<td><?php echo $product->barcode; ?></td>
			<td><?php echo $product->quantity; ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>