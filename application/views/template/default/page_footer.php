	<?php
		echo isset($extra_footer)?$extra_footer:"";
	?>
	<script>
		var base_url = '<?php echo base_url() ?>';
	</script>
	<script src="<?php echo base_url("assets/js/jquery-1.11.3.min.js"); ?>"></script>
	<?php
		if(isset($js_files)) {
			foreach($js_files as $file):
	?>
				<script src="<?php echo $file; ?>"></script>
	<?php
			endforeach;
		}
	?>
	<script src="<?php echo base_url("assets/grocery_crud/js/jquery_plugins/ui/jquery-ui-1.10.3.custom.min.js"); ?>"></script>
	<script src="<?php echo base_url("assets/bootstrap/js/bootstrap.min.js"); ?>"></script>
	<script src="<?php echo base_url("assets/bower_components/moment/min/moment.min.js"); ?>"></script>
	<script src="<?php echo base_url("assets/js/daterangepicker.js"); ?>"></script>
	<script>
		$.fn.bootstrapBtn = $.fn.button.noConflict();
	</script>
	<script src="<?php echo base_url("assets/js/jquery.appendGrid-1.6.1.min.js"); ?>"></script>
	<?php if(isset($custom_script)) { ?>
		<script src="<?php echo base_url("assets/js/$custom_script"); ?>"></script>
	<?php }
	