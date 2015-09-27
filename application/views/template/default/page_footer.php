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
	<script src="<?php echo base_url("assets/select2/select2.min.js"); ?>"></script>
	
	<script src="<?php echo base_url("assets/js/utils.js"); ?>"></script>
	<script src="<?php echo base_url("assets/js/datetime_helper.js"); ?>"></script>
	<?php if(isset($custom_script)) { ?>
		<script src="<?php echo base_url("assets/js/$custom_script"); ?>"></script>
	<?php } ?>
	
	<!-- Google Analytics -->
	<script>
		
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-66329541-1', 'auto');
		ga('send', 'pageview');
		
	</script>
	<!-- End Google Analytics -->