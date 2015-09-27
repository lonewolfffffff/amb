<body class="<?php echo isset($body_class)?$body_class:""; ?>">
	<?php
		if(isset($modals)) {
			foreach($modals as $modal) {
				$this->load->view($modal);
			}
		}
		$this->load->view("template/admin/page_header");
		$this->load->view("page/".$page);
		$this->load->view("template/admin/page_footer");
	?>
</body>