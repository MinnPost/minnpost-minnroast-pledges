<table class="all-pledges">
	<?php
	$total   = '';
	$counter = 0;
	while ( $row = $result->fetch( PDO::FETCH_ASSOC ) ) {
		$total = (int) $total + (int) $row['amount'];
		?>
		<tr>
			<td class="count"><?php echo ++$counter; ?></td>
			<td class="amount"><strong>&#36;<?php echo number_format( (int) $row['amount'] ); ?></strong></td>
			<td class="time"><?php echo get_timeago( strtotime( $row['created'] ) ); ?></td>
		</tr>
	<?php } ?>
	<tr>
		<td class="count">Total</td>
		<td class="amount"><strong>&#36;<?php echo number_format( (int) $total ); ?></strong></td>
		<td class="time">&nbsp;</td>
	</tr>
</table>
