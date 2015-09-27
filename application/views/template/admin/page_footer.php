			</div>
		</div>
	</div>
	<?php
		echo isset($extra_footer)?$extra_footer:"";
	?>
	<script>
		var base_url = '<?php echo base_url() ?>';
	</script>
	<script src="<?php echo base_url("assets/js/jquery-1.11.3.min.js"); ?>"></script>
	<script src="<?php echo base_url("assets/js/jquery-ui/jquery-ui.min.js"); ?>"></script>
	<script src="<?php echo base_url("assets/bootstrap/js/bootstrap.min.js"); ?>"></script>
	<script src="<?php echo base_url("assets/bower_components/moment/min/moment.min.js"); ?>"></script>
	<script src="<?php echo base_url("assets/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"); ?>"></script>
	<script src="<?php echo base_url("assets/js/admin/custom.js"); ?>"></script>
	
	<?php if(isset($custom_script)) { ?>
		<script src="<?php echo base_url("assets/js/$custom_script"); ?>"></script>
	<?php }