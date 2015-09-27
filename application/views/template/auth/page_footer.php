
	</div>
	<?php
		echo isset($extra_footer)?$extra_footer:"";
	?>
	<script>
		var base_url = '<?php echo base_url() ?>';
	</script>
	<script src="<?php echo base_url("assets/js/jquery-1.11.3.min.js"); ?>"></script>
	<script src="<?php echo base_url("assets/bootstrap/js/bootstrap.min.js"); ?>"></script>
	
	<?php if(isset($custom_script)) { ?>
		<script src="<?php echo base_url("assets/js/$custom_script"); ?>"></script>
	<?php }