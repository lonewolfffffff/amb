<h4 class="page-header">Daftar Produk dan Harga</h4>
<button class="btn btn-default" type="button">Tambah</button>
<div>&nbsp;</div>
<table class="table table-bordered table-condensed table-striped">
	<thead>
		<tr>
			<th>Barcode</th>
			<th>Nama Barang</th>
			<th>Harga</th>
			<th></th>
		</tr>
	</thead>
	<?php if($products) { ?>
	<tbody>
		<?php foreach($products as $product) { ?>
		<tr>
			<td><?php echo $product->barcode; ?></td>
			<td><?php echo $product->name; ?></td>
			<td><?php echo $product->price; ?></td>
			<td>
				<div class="btn-group">
					<button type="button" class="btn btn-default">Koreksi</button>
					<button type="button" class="btn btn-default">Hapus</button>
				</div>
			</td>
		</tr>
		<?php } ?>
	</tbody>
	<?php } else {?>
	<tbody>
		<tr>
			<td colspan="4">Maaf, data tidak ditemukan</td>
		</tr>

	</tbody>
	<?php } ?>
</table>


