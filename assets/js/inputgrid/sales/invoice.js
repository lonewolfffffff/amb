$(function() {
	if($('#invoice_items').length) {
		$('#invoice_items').appendGrid({
			columns: gColumns,
			initData: gData
		});
		
		$(document).on('keypress', 'form', function(event) {
			return event.keyCode !== 13;
		});

		$(document).on('click', '#form-button-save,#save-and-go-back-button', function(event) {
			$('.after-disc, .total').prop('disabled',false);
		});

		$(document).on('change','.quantity',function() {
			rowIndex = $(this).attr('id').replace('invoice_items_quantity','');
			$('#invoice_items_total'+rowIndex).trigger('change');
		});

		$(document).on('change','.unit-price',function() {
			rowIndex = $(this).attr('id').replace('invoice_items_unit_price','');
			$('#invoice_items_after_discount'+rowIndex).trigger('change');
		});

		$(document).on('change','.disc-pctg',function() {
			rowIndex = $(this).attr('id').replace('invoice_items_discount_percentage','');
			$('#invoice_items_after_discount'+rowIndex).trigger('change');
		});

		$(document).on('change','.disc-amt',function() {
			rowIndex = $(this).attr('id').replace('invoice_items_discount_amount','');
			$('#invoice_items_after_discount'+rowIndex).trigger('change');
		});

		$(document).on('change','.after-disc',function() {
			rowIndex = $(this).attr('id').replace('invoice_items_after_discount','');

			unit_price = parseInt($('#invoice_items_unit_price'+rowIndex).val(),10);
			discount_percentage = parseInt($('#invoice_items_discount_percentage'+rowIndex).val(),10);
			discount_amount = parseInt($('#invoice_items_discount_amount'+rowIndex).val(),10);
			if(unit_price) {
				discounted_unit_price = unit_price;
				if(discount_percentage) {
					discounted_unit_price = unit_price * (100-discount_percentage)/100;
				}
				if(discount_amount) {
					discounted_unit_price -= discount_amount;
				}
				$('#invoice_items_after_discount'+rowIndex).val(discounted_unit_price);
			}
			else {
				$('#invoice_items_after_discount'+rowIndex).val(0);
			}

			$('#invoice_items_total'+rowIndex).trigger('change');
		});

		$(document).on('change','.disc-distrib',function() {
			rowIndex = $(this).attr('id').replace('invoice_items_discount_distribution','');
			$('#invoice_items_total'+rowIndex).trigger('change');
		});

		$(document).on('change','.total',function() {
			rowIndex = $(this).attr('id').replace('invoice_items_total','');
			after_discount_price = parseInt($('#invoice_items_after_discount'+rowIndex).val(),10);
			if(after_discount_price) {
				quantity = parseInt($('#invoice_items_quantity'+rowIndex).val(),10);
				$('#invoice_items_total'+rowIndex).val((after_discount_price*quantity));
			}

			$('#subtotal_before_tax').trigger('change');
		});

		$(document).on('change','#subtotal_before_tax',function() {
			var subtotal = 0;
			$('.total').each(function() {
				total = parseInt($(this).val(),10);
				if(total) {
					subtotal += total;
				}
			});
			$('#subtotal_before_tax').val(subtotal);

			$('#tax').trigger('change');
		});

		$(document).on('change','#tax',function() {
			if($('#subtotal_before_tax').is(':visible')) {
				$('#tax').val(parseInt($('#subtotal_before_tax').val(),10)*10/100);
			}
			else {
				$('#tax').val(0);
			}
			$('#net_total').trigger('change');
		});

		$(document).on('change','#net_total',function() {
			$('#net_total').val(parseInt($('#subtotal_before_tax').val(),10) + parseInt($('#tax').val(),10));
		});
		
		$('#subtotal_before_tax').trigger('change');
	}
	
	if($('#print-button').length) {
		$(document).on('click','#print-button',function(event) {
			event.preventDefault();
			window.print();
		});
	}
	
	if($('#field-invoice_date').length) {
		$(document).on('change','#field-invoice_date',function() {
			var new_date = moment($(this).val(),'DD/MM/YYYY');
			var bulan = new_date.format('MM');
			var tahun = new_date.format('YYYY');
			$.get(base_url+'sales/invoice/get_last_ref/'+bulan+'/'+tahun+'/1').done(function(data) {
				$('#span_invoice_ref').text(data.new_invoice_ref);
				$('#input_invoice_ref').val(data.new_invoice_ref);
			});
		});
	}
});