	<?php
		echo isset($extra_footer)?$extra_footer:"";
	?>
	<script>
		var base_url = '<?php echo base_url() ?>';
	</script>
	<?php
		if(isset($js_files)) {
			foreach($js_files as $file):
	?>
				<script src="<?php echo $file; ?>"></script>
	<?php
			endforeach;
		}
	?>
	
	<script src="<?php echo base_url("assets/js/jquery.appendGrid-1.6.1.min.js"); ?>"></script>
	<script src="<?php echo base_url("assets/bootstrap/js/bootstrap.min.js"); ?>"></script>
	<script src="<?php echo base_url("assets/bower_components/moment/min/moment.min.js"); ?>"></script>
	<script src="<?php echo base_url("assets/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"); ?>"></script>
	<script src="<?php echo base_url("assets/select2/select2.min.js"); ?>"></script>
	
	<script src="<?php echo base_url("assets/js/utils.js"); ?>"></script>
	<script src="<?php echo base_url("assets/js/datetime_helper.js"); ?>"></script>
	<?php if(isset($custom_script)) { ?>
		<script src="<?php echo base_url("assets/js/$custom_script"); ?>"></script>
	<?php } ?>