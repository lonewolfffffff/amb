<div class="home_inner">
<div id="longWeekendModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">List of public holidays</h4>
			</div>
			<div class="modal-body">
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th>Date</th>
							<th>Description</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($public_holidays as $holiday) { ?>
						<tr>
							<td><?php echo $holiday->date_formatted; ?></td>
							<td><?php echo $holiday->description; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-sm" id="btn_close" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="jumbotron">
	<h1>Weekend away</h1>
	<p>Find available flights to get away for weekend breaks</p>
</div>

<form class="form-inline" method="post" action="<?php echo base_url("destination"); ?>">
	<input type="hidden" id="country" name="country" value="<?php echo $country; ?>">
	<input type="hidden" id="currency" name="currency" value="<?php echo $currency; ?>">
	<input type="hidden" id="locale" name="locale" value="<?php echo $locale; ?>">
	
	<div class="form-group">
		<div class="form-group form-group-sm text-center">
			<div>
				<input type="text" class="form-control input-sm" name="departing_city" id="input_origin" autocomplete="off" value="<?php echo $nearest_airport->city; ?>">
				<input type="hidden" name="origin" value="<?php echo $nearest_airport->code; ?>" id="hidden_input_origin">
			</div>
			<div class="white">
				<label>From</label>
			</div>
		</div>
		<div class="form-group form-group-sm text-center">
			<div>
				<input type="text" class="form-control input-sm" name="return_city" id="input_destination" autocomplete="off" value="Anywhere">
				<input type="hidden" name="destination" value="" id="hidden_input_destination">
			</div>
			<div class="white"><label>To</label></div>
		</div>
		<div class="form-group form-group-sm text-center">
			<div class="input-group" id="datetimepicker_depart">
				<input type="text" class="form-control input-sm" autocomplete="off" value="<?php echo $next_weekend->depart;?>" id="datetime_depart">
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>
			<div class="white">
				<label>Depart</label>
				<input type="hidden" name="date_depart" value="<?php echo $next_weekend->date_depart; ?>" id="hidden_date_depart">
				<input type="hidden" name="time_depart" value="<?php echo $next_weekend->time_depart; ?>" id="hidden_time_depart">
			</div>
		</div>
		<div class="form-group form-group-sm text-center">
			<div class="input-group" id="datetimepicker_return">
				<input type="text" class="form-control input-sm" autocomplete="off" value="<?php echo $next_weekend->return;?>" id="datetime_return">
				<span class="input-group-addon">
					<span class="glyphicon glyphicon-calendar"></span>
				</span>
			</div>
			<div class="white"><label>Return</label></div>
			<input type="hidden" name="date_return" value="<?php echo $next_weekend->date_return; ?>" id="hidden_date_return">
			<input type="hidden" name="time_return" value="<?php echo $next_weekend->time_return; ?>" id="hidden_time_return">
		</div>
		
		<div class="form-group form-group-sm text-center">
			<button type="submit" class="btn btn-warning btn-sm">Search</button>
			<div><label>&nbsp;</label></div>
		</div>
	</div>
	
	<div class="<?php echo $weekend_type_class; ?> checin">
		<div class="row">
			<div class="form-group form-checkboxes">
				
					<input id="this_weekend" type="checkbox" checked data-datetime-depart="<?php echo $next_weekend->depart;?>" data-datetime-return="<?php echo $next_weekend->return;?>" class="weekend_type" name="this_weekend" value="1">
				<label for="this_weekend">This weekend</label>
			</div>
		</div>
		
		<?php if($next_long_weekend->error) { ?>
			<div class="row form-checkboxes">
				<div class="form-group">
					<label>
						<input type="checkbox" data-datetime-depart="<?php echo $next_weekend->depart;?>" data-datetime-return="<?php echo $next_weekend->return;?>" class="weekend_type" name="next_long_weekend" value="1">
						Long weekend - next public holiday <a href="#" data-toggle="modal" data-target="#longWeekendModal">view calendar</a>
					</label>
				</div>
			</div>
		<?php } else { ?>
			<div class="row">
				<div class="form-group form-checkboxes">
					
						<input id="next_long_weekend" type="checkbox" data-datetime-depart="<?php echo $next_long_weekend->depart;?>" data-datetime-return="<?php echo $next_long_weekend->return;?>" class="weekend_type" name="next_long_weekend" value="1">
					<label for="next_long_weekend">	Long weekend - next public holiday <a href="#" data-toggle="modal" data-target="#longWeekendModal">view calendar</a></label>
				</div>
			</div>
		<?php } ?>
		
	</div>
	
	<input type="hidden" name="duration" value="8">
</form>

</div>

