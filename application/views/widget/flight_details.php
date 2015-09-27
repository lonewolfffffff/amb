<div class="destinations_waybox clearfix">
	<div class="destinations_airlog"><img src="<?php echo $carrier->ImageUrl; ?>" alt="logo"></div>
	<div class="destinations_depart">
		<p>Depart: <span class="bold"><?php echo date('l',strtotime($depart->date)); ?> <?php echo date('h:ia',strtotime($depart->time)); ?></span></p>
		<p>Arrive: <span class="bold"><?php echo date('h:ia',strtotime($depart->arrive)); ?></span></p>
	</div>
	<div class="destinations_depart">
		<p>Return: <span class="bold"><?php echo date('l',strtotime($return->date)); ?> <?php echo date('h:ia',strtotime($return->time)); ?></span></p>
		<p>Arrive: <span class="bold"><?php echo date('h:ia',strtotime($return->arrive)); ?></span></p>
	</div>
</div>
<div class="destinations_readmore"><a href="<?php echo $deeplink; ?>" target="_blank" rel="nofollow">More Details <i class="fa fa-angle-right"></i></a></div>
<span class="destination_price">
	<small><?php echo $currency->Symbol; ?></small>
	<?php echo number_format($price_starting_from, $currency->DecimalDigits, $currency->DecimalSeparator, $currency->ThousandsSeparator); ?>
</span>
<?php /*?><small>From</small>
<small><?php echo $currency->Symbol; ?></small><?php echo number_format($price_starting_from, $currency->DecimalDigits, $currency->DecimalSeparator, $currency->ThousandsSeparator); ?><?php */?>