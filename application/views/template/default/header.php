<head>
	<title>Australindo Makmur Bersama</title>
	<meta charset="UTF-8">
	<meta name="description" content="Ronthkard"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/css/bootstrap.min.css"); ?>">
	<link rel="stylesheet" href="<?php echo base_url("assets/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css"); ?>" />
	<link rel="stylesheet" href="<?php echo base_url("assets/font-awesome-4.4.0/css/font-awesome.min.css"); ?>" />
	<link rel="stylesheet" href="<?php echo base_url("assets/js/jquery-ui/jquery-ui.theme.min.css"); ?>">
	<link rel="stylesheet" href="<?php echo base_url("assets/select2/select2.min.css"); ?>">
	<?php
		if(isset($css_files)) {
			foreach($css_files as $file): 
	?>
		<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
	<?php
			endforeach;
		}
	?>
	<link rel="stylesheet" href="<?php echo base_url("assets/css/style.css?version=1.0"); ?>">
</head>