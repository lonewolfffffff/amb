<nav class="navbar navbar-fixed-top">
	<div class="container-fluid">
		<div class="navbar-header">
			<button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="<?php echo base_url(); ?>" class="navbar-brand">
				<img id="logo" title="logo" alt="Australindo" src="<?php echo base_url('assets/img/logo.png'); ?>" class="img-responsive"/>
			</a>
		</div>
		<div class="navbar-collapse collapse" id="navbar">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="<?php echo base_url(); ?>">Dashboard</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						<i class="fa fa-user"></i>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li class="dropdown-header">
							
						</li>
						<li><a href="<?php echo base_url('logout'); ?>">Log out</a></li>
					</ul>
					
				</li>
			</ul>
			<form class="navbar-form navbar-right">
				<input type="text" placeholder="Search..." class="form-control">
			</form>
		</div>
	</div>
</nav>