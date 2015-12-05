<form class="form-horizontal" method="post">
	<div class="form-group">
		<div class="col-md-6">
			<div class="form-group form-group-sm row">
				<label class="col-md-2 control-label">Periode</label>
				<div class="col-md-5">
					<input type="text" name="report_daterange" class="form-control" value="<?php echo $report_daterange; ?>" readonly="readonly">
				</div>
				<button class="btn btn-info btn-sm">Tampilkan</button>
			</div>
		</div>
	</div>
</form>
<table class="table table-bordered table-condensed table-hover table-striped">
	<thead>
		<tr>
			<th>Barcode</th>
			<th>Barang</th>
			<th>Saldo Awal</th>
			<th>Masuk</th>
			<th>Keluar</th>
			<th>Saldo Akhir</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($products as $product) { ?>
			<tr>
				<td><?php echo $product->barcode; ?></td>
				<td><?php echo $product->name; ?></td>
				<td><?php echo $product->saldo_awal; ?></td>
				<td><?php echo $product->jumlah_masuk; ?></td>
				<td><?php echo $product->jumlah_keluar; ?></td>
				<td><?php echo $product->saldo_akhir; ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>