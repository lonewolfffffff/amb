<body class="<?php echo isset($body_class)?$body_class:""; ?>">
	<?php
		$this->load->view("template/print/page_header");
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-1 col-sm-1 col-md-2 sidebar hidden-print">
				<?php $this->load->view('template/print/sidebar'); ?>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-2 main">
				<div><?php $this->load->view('page/'.$page); ?></div>
			</div>
		</div>
	</div>
	<?php
		$this->load->view("template/print/page_footer");
	?>
</body>