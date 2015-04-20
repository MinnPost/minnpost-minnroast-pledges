<table class="all-pledges">
<?php while($row = $result->fetch_assoc()){ ?>
	<tr>
		<td><strong>&#36;<?php echo number_format($row['amount'], 2); ?></strong></td>
		<td><?php echo get_timeago(strtotime($row['created'])); ?></td>
	</tr>
<?php } ?>
</table>