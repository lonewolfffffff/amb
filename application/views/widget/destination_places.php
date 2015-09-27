<?php
	if($destinations) {
		foreach($destinations as $i=>$destination) {
?>
		<div class="destinations_item clearfix" data-place-name="<?php echo $destination->name; ?>">
		
            <div class="destinations_item_name"><?php echo $destination->name; ?> <span class="destinations_item_price hidden">- From <span class="yellow bold"></span></span></div>
			
			<div class="destinations_item_detail clearfix">
				Finding flight details <i class="fa fa-spinner fa-pulse"></i>
				<script>
					destination.getFlights("<?php echo $destination->name; ?>");
				</script>
			</div>
			
            <div class="destinations_delete">
                <button type="button" aria-label="Close" data-toggle="tooltip" data-placement="top" title="Remove this destination - I don't want to go here">
                    <i class="fa fa-close"></i> Remove
                </button>
            </div>
            
		</div>
<?php
		}
	}
	else {
		if(isset($error_message)) {
			?>
			<tr>
				<td colspan="5">
					<div class="alert alert-danger">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<span class="sr-only">Error:</span>
						<?php echo $error_message; ?>
					</div>
				</td>
			</tr>
			<?php
		}
	}