<body class="<?php echo isset($body_class)?$body_class:""; ?>">
	<?php
		$this->load->view("template/auth/page_header");
		$this->load->view("page/".$page);
		$this->load->view("template/auth/page_footer");
	?>
</body>