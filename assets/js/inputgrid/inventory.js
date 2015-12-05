$(function() {
	if($('#inventory_items').length) {
		$('#inventory_items').appendGrid({
			columns: gColumns,
			initData: gData
		});
	}
});