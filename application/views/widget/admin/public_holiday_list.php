<table class="table table-bordered table-condensed table-striped">
	<thead>
		<tr>
			<th>Date</th>
			<th>State</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($holidays as $holiday) { ?>
		<tr>
			<td><?php echo $holiday->date; ?></td>
			<td><?php echo $holiday->state_id; ?></td>
			<td><?php echo $holiday->description; ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>