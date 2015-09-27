/* 
 * 
 * 
 * 
 */

$('#countryModal').on('show.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var country_name = button.data('country');
	var list_type = button.data('list');
	var modal = $(this);
	modal.find('.modal-title').text(country_name + ' ' + list_type);
	modal.find('.modal-body').empty();
});

$('#countryModal').on('shown.bs.modal', function (event) {
	var button = $(event.relatedTarget);
	var country_code = button.data('country-code');
	var list_type = button.data('list');
	var modal = $(this);
	if(list_type === 'Public Holidays') {
		data_url = 'public_holiday';
	}
	else {
		data_url = 'destination';
	}
	$.get(base_url+'admin/country/'+data_url+'/'+country_code).done(function(data) {
		modal.find('.modal-body').html(data);
	});
	
});