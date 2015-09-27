<body class="<?php echo isset($body_class)?$body_class:""; ?>">
	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<img src="<?php echo base_url("assets/img/F208778870.jpg"); ?>" alt="">
			</div>
			<div class="item">
				<img src="<?php echo base_url("assets/img/F208778872.jpg"); ?>" alt="">
			</div>
			<div class="item">
				<img src="<?php echo base_url("assets/img/F208778875.jpg"); ?>" alt="">
			</div>
		</div>

	</div>
	<?php
		$this->load->view("template/default/page_header");
		$this->load->view("page/".$page);
		$this->load->view("template/default/page_footer");
	?>
</body>