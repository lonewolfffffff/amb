<table id="sj_items"></table>
<div class="form-horizontal" style="margin-top:20px;">
	<div class="form-group subtotal_before_tax collapse">
		<label class="col-sm-2 control-label col-md-offset-7">Sub Total</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" name="subtotal_before_tax" id="subtotal_before_tax" style="width:185px;" readonly="readonly">
		</div>
	</div>
	<div class="form-group tax collapse">
		<label class="col-sm-2 control-label col-md-offset-7">PPN</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" name="tax" id="tax"style="width:185px;" readonly="readonly">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2 control-label col-md-offset-7">Total Netto</label>
		<div class="col-sm-3">
			<input type="text" class="form-control" name="net_total" id="net_total" style="width:185px;" readonly="readonly" value="<?php echo $net_total; ?>">
		</div>
	</div>
</div>
<script>
	var product = <?php echo $product_list; ?>;
	// Prepare common variables
	var gColumns = [
		{ name: 'taxable', type: 'hidden'},
		{ name: 'product_id', display: 'Barang', type: 'select',ctrlOptions:product, ctrlAttr: { maxlength: 100,class:'grid_product_list' }, ctrlCss: { width: '400px' } },
		{ name: 'quantity', display: 'Qty', type: 'text', ctrlAttr: { maxlength: 3,'class':'quantity' }, ctrlCss: { width: '50px' } },
		{ name: 'unit_price', display: 'Harga Satuan', type: 'text', ctrlAttr: { maxlength: 7,'class':'unit-price',readonly:'readonly' }, ctrlCss: { width: '100px' } },
		{ name: 'discount_percentage', display: 'Diskon(%)', type: 'text', ctrlAttr: { maxlength: 7,'class':'disc-pctg' }, ctrlCss: { width: '50px' } },
		{ name: 'discount_amount', display: 'Diskon(Rp)', type: 'text', ctrlAttr: { maxlength: 7,'class':'disc-amt' }, ctrlCss: { width: '100px' } },
		{ name: 'after_discount', display: 'Harga-Diskon', type: 'text', ctrlAttr: { maxlength: 8,'class':'after-disc',readonly:'readonly' }, ctrlCss: { width: '100px' } },
		{ name: 'tax', display: 'PPN', type: 'text', ctrlAttr: { maxlength: 8,'class':'tax',readonly:'readonly' }, ctrlCss: { width: '100px' } },
		{ name: 'total', display: 'Total', type: 'text', ctrlAttr: { maxlength: 8,'class':'total',readonly:'readonly' }, ctrlCss: { width: '100px' } }
	], gData = <?php echo $grid_data; ?>;
</script>