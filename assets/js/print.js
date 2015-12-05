$(function() {
	if($('#print-button').length) {
		$(document).on('click','#print-button',function(event) {
			event.preventDefault();
			window.print();
		});
	}
});