<table id="inventory_items"></table>
<script>
	var product = <?php echo $product_list; ?>;
	// Prepare common variables
	var gColumns = [
		{ name: 'product_id', display: 'Barang', type: 'select',ctrlOptions:product, ctrlAttr: { maxlength: 100,class:'grid_product_list' }, ctrlCss: { width: '500px' } },
		{ name: 'expiry_date', display: 'Kadaluarsa', type: 'ui-datepicker', ctrlAttr: { maxlength: 10 }, ctrlCss: { width: '100px' }},
		{ name: 'quantity', display: 'Quantity', type: 'text', ctrlAttr: { maxlength: 3 }, ctrlCss: { width: '50px' } }
	], gData = <?php echo $grid_data; ?>;
</script>