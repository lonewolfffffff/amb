<body class="<?php echo isset($body_class)?$body_class:""; ?>">
	<?php
		if(isset($modals)) {
			foreach($modals as $modal) {
				$this->load->view('widget/modal/'.$modal);
			}
		}
		$this->load->view("template/default/page_header");
	?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 col-md-2 sidebar">
				<?php $this->load->view('template/default/sidebar'); ?>
			</div>
			<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
				<h4 class="page-header"><?php echo $page_title; ?></h4>
				<div><?php $this->load->view('page/'.$page); ?></div>
			</div>
		</div>
	</div>
	<?php
		$this->load->view("template/default/page_footer");
	?>
</body>