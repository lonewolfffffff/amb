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
			<th>Tanggal</th>
			<th>Nomor Invoice</th>
			<th>Nomor PO</th>
			<th>Nomor Surat Jalan</th>
			<th>Customer</th>
			<th>Total</th>
			<th></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="5"></td>
			<td><strong><?php echo $total_sales; ?></strong></td>
			<td></td>
		</tr>
	</tfoot>
	<tbody>
		<?php foreach($invoices as $invoice) { ?>
			<tr>
				<td><?php echo $invoice->date_invoice; ?></td>
				<td><?php echo $invoice->invoice_no; ?></td>
				<td><?php echo $invoice->po_no; ?></td>
				<td><?php echo $invoice->surat_jalan_no; ?></td>
				<td><?php echo $invoice->customer; ?></td>
				<td><?php echo $invoice->total; ?></td>
				<td></td>
			</tr>
		<?php } ?>
	</tbody>
</table>