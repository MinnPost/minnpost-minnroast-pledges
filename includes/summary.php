<section class="board">
	<?php if ( true === $board_show_total_heading ) : ?>
		<?php $total_class_ext = ' total-pledges-after-heading'; ?>
		<h3>Current total:</h3>
	<?php endif; ?>
	<div class="total-pledges<?php echo $total_class_ext ?? ''; ?>">
		<?php if ( true === $board_show_count ) : ?>
			<strong><?php echo $count; ?></strong> <?php echo $word; ?> &mdash; &#36;<?php echo number_format( $total ); ?>
		<?php else : ?>
			<strong>&#36;<?php echo number_format( $total ); ?></strong>
		<?php endif; ?>
	</div>
	<?php if ( true === $board_show_names_heading ) : ?>
		<h3>Thank you to these supporters:</h3>
		<?php $name_class_ext = ' name-after-heading'; ?>
	<?php endif; ?>
	<?php if ( ! empty( $name ) && true === $board_show_names ) : ?>
		<div class="name<?php echo $name_class_ext ?? ''; ?>">
			<?php echo $name; ?>
		</div>
	<?php endif; ?>
	<?php if ( true === $board_show_pledge_heading ) : ?>
		<h3>PLEDGE NOW: MRpledge.com</h3>
	<?php endif; ?>
</section>
