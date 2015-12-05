<div class="container-fluid">
	<div class="row">
		<div class="col-xs-6"><h4>CV AUSTRALINDO MAKMUR BERSAMA</h4></div>
		<div class="col-xs-6"><h4>SURAT JALAN</h4></div>
	</div>
	<div class="row">
		<div class="col-xs-6">
			<div>Green Permata (Acacia 23)</div>
			<div>Jalan Swadarma 63</div>
			<div>Ulujami - Jakarta Selatan 12250</div>
			<div style="margin-top:1px;">Tel: 94883439/08155261631/082110439043</div>
			<div style="margin-top:1px;">Fax: 22540593</div>
			<div style="margin-top:1px;">Email: suzan7273@hotmail.com</div>
		</div>
		<div class="col-xs-6">
			<div class="row">
				<div class="col-xs-2">Kepada</div>
				<div class="col-xs-10"><?php echo $header->name; ?></div>
			</div>
			<div class="row">
				<div class="col-xs-2"></div>
				<div class="col-xs-10"><?php echo $header->address; ?></div>
			</div>
			<div class="row">
				<div class="col-xs-2">&nbsp;</div>
				<div class="col-xs-10"><?php echo $header->address2; ?></div>
			</div>
			<div class="row" style="margin-top:5px;">
				<div class="col-xs-6">Nomor PO</div>
				<div class="col-xs-6"><?php echo $header->po_ref; ?></div>
			</div>
			<div class="row">
				<div class="col-xs-6">Tanggal</div>
				<div class="col-xs-6"><?php echo $header->surat_jalan_date; ?></div>
			</div>
			<div class="row">
				<div class="col-xs-6">Nomor Surat Jalan</div>
				<div class="col-xs-6"><?php echo $header->surat_jalan_ref; ?></div>
			</div>
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
						<th>PPN</th>
						<th>Total</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="8" class="text-right"><strong>Total</strong></td>
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
							<td><?php echo $product->tax; ?></td>
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
						<th>Penerima</th>
						<th>Pengirim</th>
					</tr>
					<tr>
						<td style="padding-top: 2cm; padding-bottom: 2cm;"></td>
						<td style="padding-top: 2cm; padding-bottom: 2cm;"></td>
					</tr>
				</thead>
			</table>
		</div>
	</div>
	<div class="row hidden-print">
		<div class="col-md-12">
			<a href="#" class="btn btn-success btn-small" id="print-button">Cetak Surat Jalan</a>
			<a href="<?php echo base_url('sales/suratjalan'); ?>" class="btn btn-default btn-small">Kembali</a>
		</div>
	</div>
</div>

