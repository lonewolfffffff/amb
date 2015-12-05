<div class="container-fluid">
	<div class="row">
		<div class="col-xs-6"><h4>CV AUSTRALINDO MAKMUR BERSAMA</h4></div>
		<div class="col-xs-4 col-xs-offset-2"><h5><strong>Kepada Yth</strong></h5></div>
	</div>
	<div class="row">
		<div class="col-xs-4">
			<div>Jalan Manyar Kerta Adi 5/34</div>
			<div>Surabaya 60116</div>
			<div>Tel:(021) 94883439/08155261631</div>
		</div>
		<div class="col-xs-4 col-xs-offset-4">
			<strong><?php echo $header->name; ?></strong>
			<div><?php echo $header->address; ?></div>
			<div><?php echo $header->address2; ?></div>
		</div>
		<div class="col-xs-4 col-xs-offset-4"></div>
	</div>
	<br>
	<div class="row">
		<div class="col-xs-4">
			<strong>Tanggal : <?php echo $header->invoice_date; ?></strong>
		</div>
		<div class="col-xs-4"><h4>Invoice</h4></div>
		<div class="col-xs-4">
			<strong>Nomor : <?php echo $header->invoice_ref; ?></strong>
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
						<th>Qty</th>
						<th>Harga Satuan</th>
						<th>Diskon</th>
						<th>Harga satuan setelah Diskon</th>
						<th>Total</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="7" class="text-right"><strong>Total Netto</strong></td>
						<td><?php echo $header->net_total; ?></td>
					</tr>
				</tfoot>
				<tbody>
					<?php foreach($products as $i=>$product) { ?>
						<tr>
							<td><?php echo $i+1; ?></td>
							<td><?php echo $product->name; ?></td>
							<td><?php echo $product->barcode; ?></td>
							<td><?php echo $product->quantity; ?></td>
							<td><?php echo $product->unit_price; ?></td>
							<td><?php echo $product->discount; ?></td>
							<td><?php echo $product->after_discount; ?></td>
							<td><?php echo $product->total; ?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<table class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th style="width: 8cm;">Jatuh Tempo:30 Hari</th>
						<th style="width: 40%">Penerima</th>
						<th>Kasir</th>
					</tr>
					<tr>
						<td>
							<?php if($header->invoice_extra_info) { ?>
								<div>Untuk pembayaran, mohon ditransfer ke:</div>
								<div>BCA Galaxy, Surabaya</div>
								<div>A/c. 7880660360</div>
								<div>A/n. CV.Australindo Makmur Bersama</div>
							<?php } ?>
						</td>
						<td style="padding-top: 2cm; padding-bottom: 2cm;"></td>
						<td style="padding-top: 2cm; padding-bottom: 2cm;"></td>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<div class="row hidden-print">
		<div class="col-md-12">
			<a href="#" class="btn btn-success btn-small" id="print-button">Cetak Invoice</a>
			<a href="<?php echo base_url('sales/invoice'); ?>" class="btn btn-default btn-small">Kembali</a>
		</div>
	</div>
</div>

