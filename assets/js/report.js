$(function () {
	$('input[name=report_daterange]').daterangepicker({
		autoApply: true,
		locale: {
            format: 'DD/MM/YYYY'
        }
	});
});