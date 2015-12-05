$(function() {
	if($('#sj_items').length) {
		$('#sj_items').appendGrid({
			columns: gColumns,
			initData: gData
		});
		
		$(document).on('keypress', 'form', function(event) {
			return event.keyCode !== 13;
		});

		$(document).on('click', '#form-button-save,#save-and-go-back-button', function(event) {
			$('.after-disc, .total').prop('disabled',false);
		});
		
		$(document).on('change','.grid_product_list',function() {
			rowIndex = $(this).attr('id').replace('sj_items_product_id','');
			
			for(var i=0;i<product.length;i++) {
				if(product[i].value===$(this).val()) {
					if(product[i].unit_price) {
						$('#sj_items_unit_price'+rowIndex).val(product[i].unit_price);
						if(product[i].ppn) {
							$('#sj_items_taxable'+rowIndex).val(product[i].ppn);
						}
						break;
					}
				}
			}
			
			if(!$('#sj_items_quantity'+rowIndex).val()) {
				$('#sj_items_quantity'+rowIndex).val(1);
			}
			$('#sj_items_after_discount'+rowIndex).trigger('change');
		});

		$(document).on('change','.quantity',function() {
			rowIndex = $(this).attr('id').replace('sj_items_quantity','');
			$('#sj_items_total'+rowIndex).trigger('change');
		});

		$(document).on('change','.unit-price',function() {
			rowIndex = $(this).attr('id').replace('sj_items_unit_price','');
			$('#sj_items_after_discount'+rowIndex).trigger('change');
		});

		$(document).on('change','.disc-pctg',function() {
			rowIndex = $(this).attr('id').replace('sj_items_discount_percentage','');
			$('#sj_items_after_discount'+rowIndex).trigger('change');
		});
		
		$(document).on('change','.disc-amt',function() {
			rowIndex = $(this).attr('id').replace('sj_items_discount_amount','');
			$('#sj_items_after_discount'+rowIndex).trigger('change');
		});

		$(document).on('change','.after-disc',function() {
			rowIndex = $(this).attr('id').replace('sj_items_after_discount','');

			unit_price = parseInt($('#sj_items_unit_price'+rowIndex).val(),10);
			discount_percentage = parseInt($('#sj_items_discount_percentage'+rowIndex).val(),10);
			discount_amount = parseInt($('#sj_items_discount_amount'+rowIndex).val(),10);
			if(unit_price) {
				discounted_unit_price = unit_price;
				if(discount_percentage) {
					discounted_unit_price = unit_price * (100-discount_percentage)/100;
				}
				if(discount_amount) {
					discounted_unit_price -= discount_amount;
				}
				$('#sj_items_after_discount'+rowIndex).val(discounted_unit_price);
			}
			else {
				$('#sj_items_after_discount'+rowIndex).val(0);
			}
			if($('#sj_items_taxable'+rowIndex).val()==='1') {
				$('#sj_items_tax'+rowIndex).val(parseInt($('#sj_items_after_discount'+rowIndex).val(),10)/10);
			}
			else {
				$('#sj_items_tax'+rowIndex).val(0);
			}

			$('#sj_items_total'+rowIndex).trigger('change');
		});

		$(document).on('change','.total',function() {
			rowIndex = $(this).attr('id').replace('sj_items_total','');
			after_discount_price = parseInt($('#sj_items_after_discount'+rowIndex).val(),10);
			tax = parseInt($('#sj_items_tax'+rowIndex).val(),10);
			if(after_discount_price) {
				quantity = parseInt($('#sj_items_quantity'+rowIndex).val(),10);
				$('#sj_items_total'+rowIndex).val(((after_discount_price+tax)*quantity));
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
			$('#net_total').val(subtotal);

			//$('#tax').trigger('change');
		});

		/*
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
		*/
	}
	
	if($('#print-button').length) {
		$(document).on('click','#print-button',function(event) {
			event.preventDefault();
			window.print();
		});
	}
	
	if($('#field-surat_jalan_date').length) {
		$(document).on('change','#field-surat_jalan_date',function() {
			var new_date = moment($(this).val(),'DD/MM/YYYY');
			var bulan = new_date.format('MM');
			var tahun = new_date.format('YYYY');
			$.get(base_url+'sales/suratjalan/get_last_ref/'+bulan+'/'+tahun+'/1').done(function(data) {
				$('#span_surat_jalan_ref').text(data.new_surat_jalan_ref);
				$('#input_surat_jalan_ref').val(data.new_surat_jalan_ref);
			});
		});
	}
	
	if($("#field-customer_id").length) {
		/*
		$("#field-customer_id").chosen().change(function() {
			$.get(base_url+'customer/tax_type/'+$('#field-customer_id').val()).done(function(customer) {
				if(customer.ppn!=='1') {
					$('.form-group.subtotal_before_tax,.form-group.tax').hide();
				}
				else {
					$('.form-group.subtotal_before_tax,.form-group.tax').show();
				}
				$('#subtotal_before_tax').trigger('change');
			});
			
		});
		*/
	}
});