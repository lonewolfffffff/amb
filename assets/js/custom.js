/*

*/

var destination = {
	getPlaces:function(destination_index) {
		destination_name = $('.destination_countries:eq('+destination_index+')').data('destination-name');
		$.post(
			base_url+'destination/places',
			{
				country:$('#country').val(),
				currency:$('#currency').val(),
				locale:$('#locale').val(),
				origin:$('#origin').val(),
				country_destination:destination_name,
				date_depart:$('#date_depart').val(),
				date_return:$('#date_return').val()
			}).done(function(data) {
				if(data) {
					$('.destination_countries:eq('+destination_index+')').html(data);
					$('[data-toggle="tooltip"]').tooltip();
				}
				else {
					console.log(destination_name+' : country is the destination');
				}
			});
	},
	getFlights:function(destination_name) {
		$.post(
			base_url+'destination/initflightdetails',
			{
				country:$('#country').val(),
				currency:$('#currency').val(),
				locale:$('#locale').val(),
				origin:$('#origin').val(),
				destination:destination_name,
				date_depart:$('#date_depart').val(),
				date_return:$('#date_return').val()
			}).done(function(data) {
				if(data.response_code===201) {
					if($('div[data-place-name="' + destination_name + '"]').length) {
						setTimeout(function() { destination.pollSession(destination_name,data.session); },3000);
					}
				}
				else {
					console.log(data.response_code);
					if($('div[data-place-name="' + destination_name + '"]').length) {
						setTimeout(function() { destination.getFlights(destination_name); },10000);
					}
				}
			});
	},
	pollSession:function(destination_name,search_session) {
		$('div[data-place-name="' + destination_name + '"] .destinations_item_detail').html('Retrieving information from multiple airlines now - please be patient <i class="fa fa-spinner fa-pulse"></i>');
		$.post(
			base_url+'destination/pollflightdetails',
			{
				'search_session':search_session,
				'time_depart':$('#time_depart').val(),
				'time_return':$('#time_return').val(),
				'stops':$('#stops').val(),
				'duration':$('#duration').val()
			}).done(function(data) {
				switch(data.response_code) {
					case 200:
						if(data.status!=='UpdatesComplete') {
							if($('div[data-place-name="' + destination_name + '"]').length) {
								setTimeout(function() {destination.pollSession(destination_name,search_session);},3000);
							}
						}
						else {
							console.log(destination_name+':'+data.body.Itineraries.length);

							if(data.body.Itineraries.length>0) {
								if($('div[data-place-name="' + destination_name + '"]').length) {
									console.log(destination_name+': get flight details');
									$.post(
										base_url+'destination/getflightdetails',
										{
											'search_session':search_session,
											'time_depart':$('#time_depart').val(),
											'time_return':$('#time_return').val()
										}).done(function(data) {
											if(data) {
												$('div[data-place-name="' + destination_name + '"] .destinations_item_detail').replaceWith(data);
												$('div[data-place-name="' + destination_name + '"] .destination_price').appendTo('div[data-place-name="' + destination_name + '"] .destinations_item_price .yellow');
												$('div[data-place-name="' + destination_name + '"] .destinations_item_price').removeClass('hidden');
											}
											else {
												console.log('schedule not feasible, '+destination_name+': removed');
												$('div[data-place-name="' + destination_name + '"]').remove();
											}
									});
								}
							}
							else {
								console.log(destination_name+': removed');
								$('div[data-place-name="' + destination_name + '"]').remove();
							}
						}
						break;
					case 429:	//429 - too many requests
						if($('div[data-place-name="' + destination_name + '"]').length) {
							$('div[data-place-name="' + destination_name + '"] .destinations_item_detail').html('Server busy - Retry in 10 seconds <i class="fa fa-spinner fa-pulse"></i>');
							setTimeout(function() {destination.pollSession(destination_name,search_session);},10000);
						}
						break;
					case 500:	//500 - server error
						console.log('Server error, '+destination_name+': removed');
						$('div[data-place-name="' + destination_name + '"]').remove();
						break;
					default:	//others
						if($('div[data-place-name="' + destination_name + '"]').length) {
							setTimeout(function() {destination.pollSession(destination_name,search_session);},3000);
						}
				}
			});
	},
	remove:function(destination_name) {
		console.log(destination_name+': manually removed');
		$('div[data-place-name="' +  destination_name + '"]').remove();
	}
};

var hide_autocomplete_messages = {noResults: '',results: function() {} };
var autocomplete_cache = {};

function location_autosuggest(component_id,hidden_variable_id) {
	$(component_id).autocomplete({
		minLength: 1,
		messages: hide_autocomplete_messages,
		delay:200,
		source: function(request,response) {
			$(component_id+' .fa-spinner').css("visibility","visible");
			
			var term = request.term;
			if(term in autocomplete_cache) {
				response(autocomplete_cache[term]);
				$(component_id+' .fa-spinner').css("visibility","hidden");
				return;
			}
			
			$.post(base_url+'location/autosuggest/nocountry',{
					'country':$('#country').val(),
					'currency':$('#currency').val(),
					'locale':$('#locale').val(),
					'query':term
				},
				function(data) {
					autocomplete_cache[term] = data;
					response(data);
					$(component_id+' .fa-spinner').css("visibility","hidden");
				});
		},
		focus: function(event,ui) {
			$(component_id).val(ui.item.PlaceName);
			return false;
		},
		select: function(event,ui) {
			$(component_id).val(ui.item.PlaceName);
			$(hidden_variable_id).val(ui.item.PlaceId.replace('-sky',''));
			return false;
		}
    })
	.autocomplete("instance")._renderItem = function(ul,item) {
		return $("<li>")
		.append(item.PlaceName + "-" + item.CountryName)
		.appendTo(ul);
	};
}

$(function () {
	$("input:text").focus(function() { $(this).select(); } );
	
	location_autosuggest('#input_origin','#hidden_input_origin');
	location_autosuggest('#input_destination','#hidden_input_destination');
	
	$('#specific_destination').autocomplete({
		position: { my : "left bottom", at: "left top" },
		minLength: 1,
		messages: hide_autocomplete_messages,
		delay:200,
		source: function(request,response) {
			$('#specific_location .fa-spinner').css("visibility","visible");
			
			var term = request.term;
			if(term in autocomplete_cache) {
				response(autocomplete_cache[term]);
				$('#specific_location .fa-spinner').css("visibility","hidden");
				return;
			}
			
			$.post(base_url+'location/autosuggest',{
					'country':$('#country').val(),
					'currency':$('#currency').val(),
					'locale':$('#locale').val(),
					'query':term
				},
				function(data) {
					autocomplete_cache[term] = data;
					response(data);
					$('#specific_location .fa-spinner').css("visibility","hidden");
				});
		},
		focus: function(event,ui) {
			$('#specific_destination').val(ui.item.PlaceName);
			return false;
		},
		select: function(event,ui) {
			$('#specific_destination').val(ui.item.PlaceName);
			$('#place_name').val(ui.item.PlaceName);
			$('#destination').val(ui.item.PlaceId.replace('-sky',''));
			return false;
		}
    })
	.autocomplete("instance")._renderItem = function(ul,item) {
		return $("<li>")
		.append(item.PlaceName + "-" + item.CountryName)
		.appendTo(ul);
	};
	
	$(document).on('click','div.destinations_delete button',function() {
		destination.remove($(this).parents('.destinations_item').data('place-name'));
	});
	
	/* when the page finished loading, starts destination search */
	$('.destination_countries').each(function(index) {
		$('[data-toggle="tooltip"]').tooltip();
		destination.getPlaces(index);
	});
	
	$('.destination_places').each(function(index) {
		place_name = $('.destination_places:eq('+index+')').data('place-name');
		destination.getFlights(place_name);
	});
	
	/* search result forms */
	$(document).on('submit','#specific_location',function(event) {
		event.preventDefault();
		$('#destination_options').trigger('submit');
	});
	
	$(document).on('submit','#destination_options',function(event) {
		//event.preventDefault();
		// convert date format
		$('#date_depart').val(moment($('#date_depart_formatted').val(),'DD-MM-YYYY').format('YYYY-MM-DD'));
		$('#time_depart').val(moment($('#time_depart_formatted').val(),'ha').format('HH:mm'));
		$('#date_return').val(moment($('#date_return_formatted').val(),'DD-MM-YYYY').format('YYYY-MM-DD'));
		$('#time_return').val(moment($('#time_return_formatted').val(),'ha').format('HH:mm'));
		
		if($('#direct_flights_only').is(':checked')) {
			$('#stops').val(0);
		}
		else {
			$('#stops').val(3);
		}
		
		$('#duration').val($('#max_duration').val());
		
	});
	
	/* spinner */
	$(document).on('click','button.spin',function() {
		
		var input_component = $(this).parents('.input-group').find('input');
		switch(input_component.data('type')) {
			case 'date':
				input_component.val(moment(input_component.val(),'DD-MM-YYYY').add(1 * spinner_multiplier($(this).data('type')),'d').format('DD-MM-YYYY'));
				break;
			case 'time':
				input_component.val(moment(input_component.val(),'ha').add(1 * spinner_multiplier($(this).data('type')),'h').format('ha'));
				break;
			case 'number':
				var current_value = parseInt(input_component.val());
				var direction = $(this).data('type');
				var legal_spin_action = true;
				if(direction==='down') {
					if(current_value === 1) {
						legal_spin_action = false;
					}
				}
				else {
					if(current_value === 8) {
						legal_spin_action = false;
					}
				}
				if(legal_spin_action) {
					input_component.val(current_value + (1 * spinner_multiplier(direction)));
				}
				break;
		}
		
	});
	
	/* DateTimePicker */
	$('#datetimepicker_depart').datetimepicker({
		format:'ddd MMM D [>] ha',
		sideBySide:true,
		allowInputToggle:true
	});
	
	$('#datetimepicker_return').datetimepicker({
		format:'ddd MMM D [<] ha',
		sideBySide:true,
		allowInputToggle:true
	});
	
	$("#datetimepicker_depart").on("dp.change", function (e) {
		$('#hidden_date_depart').val(moment(e.date,'ddd MMM D [>] ha').format('YYYY-MM-DD'));
		$('#hidden_time_depart').val(moment(e.date,'ddd MMM D [>] ha').format('HH:mm'));
		$('#datetimepicker_return').data("DateTimePicker").minDate(e.date);
		
	});
	
	$("#datetimepicker_return").on("dp.change", function (e) {
		$('#hidden_date_return').val(moment(e.date,'ddd MMM D [<] ha').format('YYYY-MM-DD'));
		$('#hidden_time_return').val(moment(e.date,'ddd MMM D [<] ha').format('HH:mm'));
		
	});
	
	$(document).on('change','input.weekend_type',function() {
		var weekend_type = $(this).attr('name');
		$('input.weekend_type').prop('checked',false);
		$('input[name=' + weekend_type + ']').prop('checked',true);
		
		$('#datetimepicker_depart').data("DateTimePicker").date($(this).data('datetime-depart'));
		$('#datetimepicker_return').data("DateTimePicker").date($(this).data('datetime-return'));
	});
	
});

$(document).ajaxStop(function() {
	if($('div.destination_countries .fa-spinner').length===0) {
		if($('div.destinations_item').length===0) {	//no destination found
			$('.no-destination').removeClass('hidden');
		}
	}
});

function update_holiday_options(weekend_type,direction) {
	var datetime = moment($('#input_datetime_'+direction).val(),'dddd DD-MM-YYYY hh:mm a');
	$('#'+weekend_type+'_hidden_date_'+direction).val(datetime.format('YYYY-MM-DD'));
	$('#'+weekend_type+'_hidden_time_'+direction).val(datetime.format('HH:mm'));
	
	// day of the week, time classification, time summary
	$('#'+weekend_type+' .'+direction+' .day_name').text(datetime.format('dddd MMMM D'));
	$('#'+weekend_type+' .'+direction+' .time_classification').text(classify_time(datetime.format('H')));
	
	if(parseInt(datetime.format('m'))===0) {
		$('#'+weekend_type+' .'+direction+' .time_summary').text(datetime.format('ha'));
	}
	else {
		$('#'+weekend_type+' .'+direction+' .time_summary').text(datetime.format('h:mma'));
	}
}

function spinner_multiplier(spin_direction) {
	if(spin_direction === 'up') {
		return 1;
	}
	else {
		return -1;
	}
}